<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost you and your team's skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# Table

## users

| Column   | Type   | Options                   |
| -------- | ------ | ------------------------- |
| name     | string | null: false               |
| email    | string | null: false, unique: true |
| password | string | null: false               |

### Association
- has_many :group_users
- has_many :task_charges
- has_many :user_work_schedules
- has_many :vehicle_work_schedules


## groups

| Column     | Type   | Options     |
| ---------- | ------ | ----------- |
| group_name | string | null: false |

### Association
- has_many :group_users
- belongs_to :project


## group_users

| Column | Type       | Options           |
| ------ | ---------- | ----------------- |
| group  | references | foreign_key: true |
| user   | references | foreign_key: true |

### Association
- belongs_to :user
- belongs_to :group


## resources

| Column        | Type    | Options           |
| ------------- | ------- | ----------------- |
| resource_name | string  | foreign_key: true |
| resource_type | boolean | default: false    |
| resource_size | integer | default: none     |

### Association
- has_many :resource_stocks
- belongs_to :project_resource


## locations

| Column        | Type   | Options     |
| ------------- | ------ | ----------- |
| location_name | string | null: false |

### Association
- has_many :resource_stocks
- has_many :project_resources


## vehicles

| Column     | Type    | Options     |
| ---------- |-------- | ----------- |
| max_weight | integer | null: false |
| max_size   | integer | null: false |

### Association
- has_many :vehicle_work_schedules


## resource_stocks

| Column   | Type       | Options           |
| -------- | ---------- | ----------------- |
| location | references | foreign_key: true |
| resource | references | foreign_key: true |
| stock    | integer    | null: false       |
| weight   | integer    | null: false       |
| size     | integer    | null: false       |

### Association
- belongs_to :location
- belongs_to :resource


## projects

| Column       | Type       | Options           |
| ------------ | ---------- | ----------------- |
| project_name | string     | null: false       |
| group        | references | foreign_key: true |
| outline      | text       | null: false       |
| file_path    | string     | null: false       |

### Association
- has_many :groups
- has_many :task_charges
- has_many :user_work_schedules
- has_many :project_resources
- has_many :vehicle_work_schedules


## task_charges

| Column      | Type       | Options           |
| ----------- | ---------- | ----------------- |
| project     | references | foreign_key: true |
| task_name   | string     | null: false       |
| user        | references | foreign_key: true |
| outline     | text       | null: false       |
| order       | integer    | null: false       |
| report      | text       |                   |
| reported_at | date       |                   |

### Association
- belongs_to :user
- belongs_to :project


## user_work_schedules

| Column    | Type       | Options           |
| --------- | ---------- | ----------------- |
| project   | references | foreign_key: true |
| user      | references | foreign_key: true |
| work_date | date       | null: false       |

### Association
- belongs_to :user
- belongs_to :project


## project_resources

| Column               | Type       | Options           |
| -------------------- | ---------- | ----------------- |
| project              | references | foreign_key: true |
| resource             | references | foreign_key: true |
| location             | references | foreign_key: true |
| consumption_quantity | integer    | null: false       |

### Association
- belongs_to :project
- belongs_to :resource
- belongs_to :location


## vehicle_work_schedules

| Column    | Type       | Options           |
| --------- | ---------- | ----------------- |
| project   | references | foreign_key: true |
| user      | references | foreign_key: true |
| vehicle   | references | foreign_key: true |
| work_date | date       | null: false       |

### Association
- belongs_to :user
- belongs_to :vehicle
- belongs_to :project