import re
import json
import os

sql_file = '/Users/fahri/Desktop/calidosol-yeni/calidosol_db_backup.sql'

with open(sql_file, 'r') as f:
    content = f.read()

# Find the INSERT statement for pages
match = re.search(r'INSERT INTO `pages` VALUES\n(.*);', content, re.DOTALL)
if not match:
    print("No match found")
    exit()

values_str = match.group(1)

# Split by line/tuple
tuples = re.findall(r'\((.*?)\)(?:,|$)', values_str, re.DOTALL)

langs = ['tr', 'en', 'de']

for t in tuples:
    # Basic CSV-like parsing, but handles escaped quotes roughly
    # Actually, it's easier to use a regex to extract fields.
    # format: id, 'slug', 'image', 'title_json', 'seo_title_json', 'seo_desc_json', 'content_json', 'components_json', ...
    
    # Let's try evaluating it as a python tuple by replacing NULL with None
    t_clean = t.replace('NULL', 'None')
    # It has some unescaped things or specific SQL escaping.
    # Let's do a more robust parsing.
    parts = []
    current = ""
    in_string = False
    escape = False
    for char in t:
        if escape:
            current += char
            escape = False
        elif char == '\\':
            current += char
            escape = True
        elif char == "'":
            in_string = not in_string
            current += char
        elif char == "," and not in_string:
            parts.append(current)
            current = ""
        else:
            current += char
    parts.append(current)
    
    if len(parts) < 8: continue
    
    slug = parts[1].strip("'")
    
    if slug == 'home' or slug == 'rooms':
        continue # Already done manually
        
    def parse_json_field(val):
        if val == 'NULL' or val == 'None': return {}
        # remove enclosing quotes and unescape \'
        val = val.strip()[1:-1]
        val = val.replace("\\'", "'")
        val = val.replace('\\\\', '\\')
        try:
            return json.loads(val)
        except Exception as e:
            print("JSON parse error for", slug, val[:50], e)
            return {}

    title = parse_json_field(parts[3])
    seo_title = parse_json_field(parts[4])
    seo_desc = parse_json_field(parts[5])
    content_html = parse_json_field(parts[6])
    components = parse_json_field(parts[7])
    
    for lang in langs:
        lang_dir = f"/Users/fahri/Desktop/calidosol-yeni/calidosol-static/lang/{lang}"
        os.makedirs(lang_dir, exist_ok=True)
        file_path = f"{lang_dir}/{slug}.php"
        
        with open(file_path, 'w') as f:
            f.write("<?php\nreturn [\n")
            
            def write_str(k, v):
                if not v: v = ""
                v = str(v).replace("'", "\\'")
                f.write(f"    '{k}' => '{v}',\n")
                
            write_str('title', title.get(lang, ''))
            write_str('seo_title', seo_title.get(lang, ''))
            write_str('seo_description', seo_desc.get(lang, ''))
            write_str('content', content_html.get(lang, ''))
            
            if components and isinstance(components, list):
                f.write("    'components' => [\n")
                for comp in components:
                    c_type = comp.get('type')
                    c_data = comp.get('data', {})
                    f.write(f"        [\n")
                    f.write(f"            'type' => '{c_type}',\n")
                    f.write(f"            'data' => [\n")
                    
                    if 'title' in c_data:
                        t_val = c_data['title'].get(lang, '') if isinstance(c_data['title'], dict) else ''
                        write_str('title', t_val)
                    
                    if c_type == 'features_list':
                        f.write("                'items' => [\n")
                        for item in c_data.get('items', []):
                            i_val = item['label'].get(lang, '') if isinstance(item['label'], dict) else ''
                            i_val = str(i_val).replace("'", "\\'")
                            f.write(f"                    '{i_val}',\n")
                        f.write("                ],\n")
                        
                    elif c_type == 'timeline_section':
                        f.write("                'items' => [\n")
                        for item in c_data.get('items', []):
                            f.write("                    [\n")
                            write_str('image', item.get('image', ''))
                            t_val = item['title'].get(lang, '') if isinstance(item.get('title'), dict) else ''
                            write_str('title', t_val)
                            c_val = item['content'].get(lang, '') if isinstance(item.get('content'), dict) else ''
                            write_str('content', c_val)
                            a_val = item.get('align', 'left')
                            write_str('align', a_val)
                            sh_val = item.get('service_hours')
                            if isinstance(sh_val, dict): sh_val = sh_val.get(lang, '')
                            write_str('service_hours', sh_val)
                            f.write("                    ],\n")
                        f.write("                ],\n")
                        
                    elif c_type == 'meal_schedule':
                        f.write("                'items' => [\n")
                        for item in c_data.get('items', []):
                            f.write("                    [\n")
                            m_val = item['meal_name'].get(lang, '') if isinstance(item.get('meal_name'), dict) else ''
                            write_str('meal_name', m_val)
                            t_val = item['time'].get(lang, '') if isinstance(item.get('time'), dict) else ''
                            write_str('time', t_val)
                            f.write("                    ],\n")
                        f.write("                ],\n")
                        
                    elif c_type == 'bars_section':
                        f.write("                'bars' => [\n")
                        for bar in c_data.get('bars', []):
                            f.write("                    [\n")
                            n_val = bar['name'].get(lang, '') if isinstance(bar.get('name'), dict) else ''
                            write_str('name', n_val)
                            h_val = bar['hours'].get(lang, '') if isinstance(bar.get('hours'), dict) else ''
                            write_str('hours', h_val)
                            f.write("                    ],\n")
                        f.write("                ],\n")
                        f.write("                'notes' => [\n")
                        for note in c_data.get('notes', []):
                            f.write("                    [\n")
                            n_val = note['text'].get(lang, '') if isinstance(note.get('text'), dict) else ''
                            write_str('text', n_val)
                            write_str('type', note.get('type', 'info'))
                            f.write("                    ],\n")
                        f.write("                ],\n")
                        
                    elif c_type == 'info_notice':
                        c_val = c_data['content'].get(lang, '') if isinstance(c_data.get('content'), dict) else ''
                        write_str('content', c_val)
                        
                    elif c_type == 'info_table':
                        h1_val = c_data['header_1'].get(lang, '') if isinstance(c_data.get('header_1'), dict) else ''
                        write_str('header_1', h1_val)
                        h2_val = c_data['header_2'].get(lang, '') if isinstance(c_data.get('header_2'), dict) else ''
                        write_str('header_2', h2_val)
                        f.write("                'items' => [\n")
                        for item in c_data.get('items', []):
                            f.write("                    [\n")
                            c1_val = item['col_1'].get(lang, '') if isinstance(item.get('col_1'), dict) else ''
                            write_str('col_1', c1_val)
                            c2_val = item['col_2'].get(lang, '') if isinstance(item.get('col_2'), dict) else ''
                            write_str('col_2', c2_val)
                            f.write("                    ],\n")
                        f.write("                ],\n")

                    f.write(f"            ],\n")
                    f.write(f"        ],\n")
                f.write("    ],\n")
                
            f.write("];\n")

print("Done")
