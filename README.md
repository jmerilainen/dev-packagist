Demo: https://jmerilainen-packagist-storage.s3.eu-north-1.amazonaws.com/index.html

## Composer scripts
```json
"scripts": {
    "generate": "bin/satis-builder build --from=packages --external=packages/external.json --name=$SATIS_NAME --homepage=$SATIS_HOMEPAGE --output=.satis.json",
    "build": "vendor/bin/satis build .satis.json dist"
}
```

## Project structure
```sh
├── .satis.json          # Generated satis.json 
├── dist/                # Generated satis repository 
└── packages/            # All included pacakges
    ├── <vendor>/
    │   ├── <package-name>-<version>.zip
    │   └── <package-name>-<version>.zip
    └── <vendor>/
        ├── <package-name>-<version>.zip
        └── <package-name>-<version>.zip
```
