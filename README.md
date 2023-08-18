<a name="readme-top"></a>

![tests-shield]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

<p align="center">
  <a href="https://github.com/incredimike/exporter-for-ynab">![Logo]</a>
</p>

<h3 align="center">Transaction Exporter For YNAB</h3>

<p align="center">
Configurable transaction export tool for YNAB online budgeting tool.
<br/>
<br/>
<a href="https://github.com/incredimike/exporter-for-ynab">View Demo</a>
•
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

![Screen Shot](images/screenshot.png)

This project was developer to experiment with Laravel 10.x by scratching an itch I've had for years: automating the export of my monthly household purchases.

Built using Test Driven Development (TDD).

## Built With

This project leverages several frameworks.

* [Laravel PHP Framework](https://laravel.com)
* [Vue.JS](https://vuejs.org)
* [Alpine.js](https://alpinejs.dev)

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
...
YNAB_API_TOKEN=<YOUR_TOKEN_HERE>
... 
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

* [YNAB](https://www.ynab.com) - Amazing online budgeting software!
* [ImgShields](https://shields.io/)


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[tests-shield1]: https://github.com/incredimike/exporter-for-ynab/actions/workflows/tests.yml/badge.svg
[tests-shield]: https://img.shields.io/github/actions/workflow/status/incredimike/exporter-for-ynab/tests.yml?style=for-the-badge
[issues-shield]: https://img.shields.io/github/issues/incredimike/exporter-for-ynab.svg?style=for-the-badge
[issues-url]: https://github.com/incredimike/exporter-for-ynab/issues
[license-shield]: https://img.shields.io/github/license/incredimike/exporter-for-ynab.svg?style=for-the-badge
[license-url]: https://github.com/incredimike/exporter-for-ynab/blob/master/LICENSE
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/incredimike
[Logo]: resources/images/exporter-for-ynab-logo.png
[screenshot]: images/screenshot.png
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
