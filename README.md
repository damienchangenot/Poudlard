## Vous savez, moi je ne crois pas qu'il y ait de bonne ou de mauvaise situation. Moi, si je devais résumer ma vie aujourd'hui avec vous, je dirais que c'est d'abord des rencontres. Des gens qui m'ont tendu la main, peut-être à un moment où je ne pouvais pas, où j'étais seul chez moi. Et c'est assez curieux de se dire que les hasards, les rencontres forgent une destinée... Parce que quand on a le goût de la chose, quand on a le goût de la chose bien faite, le beau geste, parfois on ne trouve pas l'interlocuteur en face je dirais, le miroir qui vous aide à avancer. Alors ça n'est pas mon cas, comme je disais là, puisque moi au contraire, j'ai pu : et je dis merci à la vie, je lui dis merci, je chante la vie, je danse la vie... je ne suis qu'amour ! Et finalement, quand beaucoup de gens aujourd'hui me disent « Mais comment fais-tu pour avoir cette humanité ? », et bien je leur réponds très simplement, je leur dis que c'est ce goût de l'amour ce goût donc qui m'a poussé aujourd'hui à entreprendre une construction mécanique, mais demain qui sait ? Peut-être simplement à me mettre au service de la communauté, à faire le don, le don de soi...

# Checkpoint 4 - Poudlard - Symfony 5.*

## Requirements

- Php ^7.2 http://php.net/manual/fr/install.php;
- Composer https://getcomposer.org/download/;
- Yarn https://classic.yarnpkg.com/en/docs/install/#debian-stable;
- Node https://nodejs.org/en/;

## Installation

1. Clone the current repository.

2. Move into the directory and create an `.env.local` file.
   **This one is not committed to the shared repository.**

3. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install
yarn install

# Create 'poudlard' DB
php bin/console doctrine:database:create

# Execute migrations and create tables
php bin/console doctrine:migrations:migrate

# Load fixtures
php bin/console doctrine:fixtures:load
```

> Reminder: Don't use composer update to avoid problem

## Usage

Run `yarn encore dev` to build assets

Run `php -S localhost:8000 -t public` or `symfony server:start` to launch server

## Authors
Damien Changenot


