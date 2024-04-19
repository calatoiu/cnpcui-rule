## 🏦 CNPCUI Validation Rule for Laravel

[![GitHub](https://img.shields.io/github/license/calatoiu/cnpcui-rule?style=flat-square)](LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/calatoiu/cnpcui-rule?style=flat-square)](Issues)
[![Packagist Downloads](https://img.shields.io/packagist/dt/calatoiu/cnpcui-rule?style=flat-square)](Downloads)
[![GitHub Release](https://img.shields.io/github/v/release/calatoiu/cnpcui-rule?style=flat-square)](Release)

This package provides a custom validation rule for Laravel to validate International Bank Account Numbers (CNPCUIs). It uses the validation rules defined by the Single Euro Payments Area (SEPA) and other non-SEPA countries to ensure that the given CNPCUI is valid.

### 🧰 Requirements
- ```PHP >= 8.1```
- ```Laravel >= 10```

### ⚙️ Installation
You can install this package using Composer:

```composer require calatoiu/cnpcui-rule```


### 👾 Usage

To use the CNPCUI validation rule, simply add it to your Laravel validation rules. Here's an example:


```php
use Illuminate\Http\Request;
use calatoiu\CnpcuiRule\ValidCnpcui;


public function store(Request $request)
{
    $request->validate([
        'cnpcui' => ['required', new ValidCnpcui()],
    ]);

    // The rest of your code
}
```

### 👽 Customize error message

You can use your own validation message (by default will be ```The :attribute is not a valid CNPCUI.```).

> :warning: **If you don't have these folders** use ```php artisan lang:publish```

Simply:
```bash
# Path
\main_folder_project
    \lang
        \app_language(ex.'en')
            validation.php

# Add 'cnpcui' key
<?php
    // validation.php inside 'it' folder

    'cnpcui' => 'CNPCUI non valido.'


# Now you're validation message will be translated!
```

### 🔐 Validation Rules
This package uses the validation rules defined by the Single Euro Payments Area (SEPA) and other non-SEPA countries to ensure that the given CNPCUI is valid. The validation rules are loaded from a `countries.json` file that is included in this package.

### 🤝 Contribution
If you find any issues or have suggestions for improvements, feel free to open a pull request or issue. Your contribution is highly appreciated.

### 🌍 Supported countries

[Full list of supported countries](https://github.com/calatoiu/nova-cnpcui-field/blob/master/COUNTRIES.md)

### 🔨 Test

```composer test```

### 📝 License

This package is open-sourced software licensed under the [MIT license](https://github.com/calatoiu/cnpcui-rule/blob/main/LICENSE.md).
