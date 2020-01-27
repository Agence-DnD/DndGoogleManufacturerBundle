# Configuration guide:

### Google Manufacturer Configuration

**General**

* Website Link

The website link will appear in the \<link> node in the resulting XML file.

Example : 
```xml
<link>http://your-website.com</link>
```

| Connector parameter     | Value                                                  |
| :-----------------------| :-----------------------------------------------------:|
| Website Link            | Link to your website (Format: http://your-website.com)   |

* Level of acceptance

Google Manufacturer Connector has 3 levels of acceptance. Those levels will trigger different validation processes depending on your needs.

The `lowest level` will disable all the Google Manufacturer custom validation process and only use the Akeneo native ones.

The `medium level` will check the requirements of product data depending on Google Manufacturer requirements.

The `highest level` will check the requirements of Google Manufacturer but also some extra-validations such as length, size, typo etc...

| Connector parameter     | Value                  |
| :-----------------------| :---------------------:|
| Level of acceptance     | Low / Medium / High    |

**Mandatory attributes**

This section is listing all the `Mandatory attributes` for Google Manufacturer system.

You have to define each corresponding attributes in your Akeneo instance for those `Mandatory attributes`.

| Connector parameter     | Value                              |
| :-----------------------| :---------------------------------:|
| Mandatory attribute     | Any attribute from your catalog    |

**Optional attributes**

This section is listing all the `Optional attributes` for Google Manufacturer system.

You can define each corresponding attributes in your Akeneo instance for those `Optional attributes`.

If you don't define a corresponding attribute for one of them, the attribute will not be exported in the XML file for Google Manufacturer.

| Connector parameter     | Value                              |
| :-----------------------| :---------------------------------:|
| Optional attribute      | Any attribute from your catalog    |

**Grouped attributes**

The `Grouped attributes` section allows you to configure the `Product Detail` nodes and the `Feature Description` nodes for Google Manufacturer.

You can define multiple `Product Detail` nodes and `Feature Description` nodes for each of your export jobs.

Result example for `Feature Description`:
```xml
<g:feature_description>
    <g:headline>Wireless Bluetooth Streaming</g:headline>
    <g:text>Wirelessly connect up to 3 smartphones or tablets to the speaker and take turns playing earth-shaking, powerful stereo sound.</g:text>
    <g:image_link>http://example.com/image1.png</g:image_link>
</g:feature_description>
```

Result example for `Product Detail`:
```xml
<g:product_detail>
    <g:section_name>General</g:section_name>
    <g:attribute_name>Product Type</g:attribute_name>
    <g:attribute_value>Digital player</g:attribute_value>
</g:product_detail>
```

| Connector parameter     | Value                              |
| :-----------------------| :---------------------------------:|
| Mandatory attribute     | Any attribute from your catalog    |

##### [> Back to summary](../summary.md)