#Itpl - template for backend

for extensions:
- [Blcms-Shop](https://github.com/black-lamp/blcms-shop)
- [Blcms-Staticpage](https://github.com/black-lamp/blcms-staticpage)

### Installation

1) For install this template, your composer.json file must contain next block:

```
    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/GutsVadim/blcms-itpl.git",
            "options": {
                "github-oauth": {
                    "github.com": "YOUR_TOKEN"
                }
            }
        }
    ]
```
You may generate your Github token [here](https://github.com/settings/tokens).

2) To work links, that direct to the frontend, you must configure the backend config:
```
'components' => [
    ...
    'urlManagerFrontend' => [
        'class' => bl\multilang\MultiLangUrlManager::className(),
        'baseUrl' => '/',
        'showScriptName' => false,
        'enablePrettyUrl' => true,
        'enableDefaultLanguageUrlCode' => false,
        'rules' => [
            [
                'class' => bl\articles\UrlRule::className()
            ],
            [
                'class' => bl\cms\shop\UrlRule::className(),
                'prefix' => 'shop'
            ],
        ]
    ]
]
```