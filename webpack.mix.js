const mix = require("laravel-mix");

require("laravel-mix-tailwind");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js("resources/js/app.js", "public/js/app.js")
    .js("node_modules/chart.js/dist/chart.umd.js", "public/js/lib/app.js")

.copy("resources/js/produtos/produto-error.js", "public/js/produtos/produto-error.js")
    .copy("resources/js/produtos/produto.js", "public/js/produtos/produto.js")
    .copy("resources/js/produtos/produto-repositorio.js", "public/js/produtos/produto-repositorio.js")
    .copy("resources/js/produtos/produto-servico.js", "public/js/produtos/produto-servico.js")
    .copy("resources/js/produtos/produto-visao.js", "public/js/produtos/produto-visao.js")
    .copy("resources/js/produtos/produto-controladora.js", "public/js/produtos/produto-controladora.js")
    .copy("resources/js/produtos/index.js", "public/js/produtos/index.js")

.copy("resources/js/vendas/venda.js", "public/js/vendas/venda.js")
    .copy("resources/js/vendas/venda-error.js", "public/js/vendas/venda-error.js")
    .copy("resources/js/vendas/venda-repositorio.js", "public/js/vendas/venda-repositorio.js")
    .copy("resources/js/vendas/venda-servico.js", "public/js/vendas/venda-servico.js")
    .copy("resources/js/vendas/venda-visao.js", "public/js/vendas/venda-visao.js")
    .copy("resources/js/vendas/venda-controladora.js", "public/js/vendas/venda-controladora.js")
    .copy("resources/js/vendas/index.js", "public/js/vendas/index.js")

.sass("resources/sass/app.scss", "public/css/app.css")
    .tailwind("./tailwind.config.js")
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}