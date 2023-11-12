1)

app/_config/component-media.yml
```
---
Name: app-component-media
---

Goldfinch\Component\Media\Models\MediaSegment:
  segment_types:
    primary:
      label: 'Single image'
      image: true
      images: false
    secondary:
      label: 'Multiple images'
      image: false
      images: true
    combo:
      label: 'Combo images'
      image: true
      images: true
```

2) 

elements.yml

```
  allowed_elements:
    - Goldfinch\Component\Media\Blocks\MediaBlock
```

3)

app/_schema/media-{segment_type}.json
```
{
    "type": "array",
    "options": {},
    "items": {
        "type": "object",
        "properties": {
            "example": {
                "title": "Example",
                "type": "string",
                "default": "default example text"
              }
        }
      }

  }
```

4)

themes/{theme}/templates/Components/Media/{segment_type}.ss

```
my custom template for specific segment type
```
