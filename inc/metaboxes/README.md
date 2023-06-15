## How fetch meta box fields

### Repeater fields:
   saved in serialized format. 
- For fetching data use helper function  ```s7_get_meta_serialize_fields('meta_key')```;
  
 ### Simple fields:
  string or number
  - For ferching data use helper function ```s7_get_meta_field('meta_key')```

 ### Media fields:
  Return array:
   - fetching data: ```get_post_meta(get_the_ID(), $meta_key) ```

### Image fields:
  array
  - For ferching image use helper function ```s7_get_image_field('meta_key')```
