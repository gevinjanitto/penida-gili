"""Regenerate ../catalogue-v2.json from the Python sources: python3 build.py"""
import json, os, sys
sys.path.insert(0, os.path.dirname(__file__))
from hotels import HOTELS
from activities import ACTIVITIES
from articles import ARTICLES

out = os.path.join(os.path.dirname(__file__), '..', 'catalogue-v2.json')
with open(out, 'w') as f:
    json.dump({'version': 2, 'hotels': HOTELS, 'activities': ACTIVITIES, 'articles': ARTICLES}, f, ensure_ascii=False, indent=1)
print('wrote', out)
