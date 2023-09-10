<a name="readme-top"></a>

![tests-shield]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

<h3 align="center">Transaction Exporter For YNAB</h3>

<p align="center">
Configurable transaction export tool for YNAB online budgeting tool.
<br/>
<br/>
<!-- <a href="https://github.com/incredimike/exporter-for-ynab">View Demo</a> 
• -->
<a href="https://github.com/incredimike/exporter-for-ynab/issues">Bug Reports</a>
•
<a href="https://github.com/incredimike/exporter-for-ynab/issues">Feature Requests</a>
</p>

## Table Of Contents

* [About the Project](#about-the-project)
* [Built With](#built-with)
* [Getting Started](#getting-started)
    * [Prerequisites](#prerequisites)
    * [Installation](#installation)
* [Usage](#usage)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)
* [Authors](#authors)
* [Acknowledgements](#acknowledgements)

## About The Project

This project aims to make exporting transaction data easier by allowing users 
to save a "template" of export settings to be reused for future exports.

I wanted to build a webapp using the latest versions of Laravel, Vue.js and Alpine.js to experiment with the new tech. I really enjoy building using the Test Driven Development (TDD) methodology, but rarely have the opportunity on client projects.

### Built With
[![Laravel]][Laravel-url]
[![PostreSQL]][PostreSQL-url]
[![Vue]][Vue-url]
[![Alpine]][Alpine-url]

## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

Since the project is based on Laravel 10.x, you'll need to have at least PHP version 8.1 installed. We also assume you have [Composer installed](https://getcomposer.org/download/) globally on your OS.

PHP can be set up locally on your OS or [install Laravel Sail](https://laravel.com/docs/10.x/sail) for an all-in-one local development solution.

### Installation

1. Create a **Personal Access Token** on the [Developer Settings page](https://app.ynab.com/settings/developer) in YNAB. Check out the YNAB documentation for more information on [getting your personal access token](https://api.ynab.com/#personal-access-tokens).

2. Clone the repo to your local machine.

```sh
git clone https://github.com/incredimike/exporter-for-ynab.git
```

3. Create a new `.env` file by copying the `.env.example` file shipped in the repo.

```sh
cp .env.example .env
```

4. Add your YNAB Developer API key to the .env file

```sh
YNAB_API_TOKEN=<YOUR_TOKEN_HERE>
```

5. Install PHP Composer packages

```sh
composer install
```

6. If using Laravel Sail, you will want to run the application locally with the following command:

```sh
sail up -d
```

## Usage

_TBD_


## Testing

You can run PHPUnit tests locally using the phpunit binary installed with composer:

```sh
vendor/bin/phpunit
```

Or you can run tests using the Sail docker containers:

```sh
sail test
```

## Roadmap

See the [open issues](https://github.com/incredimike/exporter-for-ynab/issues) for a list of proposed features (and known issues).

## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.
* If you have suggestions for adding or removing features, feel free to [open an issue](https://github.com/incredimike/exporter-for-ynab/issues/new) to discuss it, or directly create a pull request.
* Create individual PR for each feature suggestion.
* Please also read through the [Code Of Conduct](https://github.com/incredimike/exporter-for-ynab/blob/main/CODE_OF_CONDUCT.md) before posting your first idea as well.

### Creating A Pull Request

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/amazing-feature`)
3. Commit your Changes (`git commit -m 'Add some Amazing Feature'`)
4. Push to the Branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

Distributed under the MIT License. See [LICENSE](https://github.com/incredimike/exporter-for-ynab/blob/main/LICENSE) for more information.

## Authors

* **Mike Walker** - *Full-Stack Web Developer* - https://incredimike.com

## Acknowledgements

* [YNAB](https://www.ynab.com) - YNAB is short for "You Need A Budget", an amazing online budgeting & financial management software system.
* [ImgShields](https://shields.io/) - ImgShields provide the images at the top of the README.

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[tests-shield]: https://img.shields.io/github/actions/workflow/status/incredimike/exporter-for-ynab/tests.yml?style=for-the-badge
[issues-shield]: https://img.shields.io/github/issues/incredimike/exporter-for-ynab.svg?style=for-the-badge
[issues-url]: https://github.com/incredimike/exporter-for-ynab/issues
[license-shield]: https://img.shields.io/github/license/incredimike/exporter-for-ynab.svg?style=for-the-badge
[license-url]: https://github.com/incredimike/exporter-for-ynab/blob/master/LICENSE
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/incredimike
[screenshot]: images/screenshot.png

[Alpine]: https://img.shields.io/badge/Alpine.js-2D3441?style=for-the-badge&logo=alpinedotjs&logoColor=77C1D2
[Alpine-url]: https://alpine.dev
[PostreSQL]: https://img.shields.io/badge/PostgreSQL-336791?style=for-the-badge&logo=postgresql&logoColor=white
[PostreSQL-url]: https://alpine.dev
[Vue]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org
[Laravel]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
