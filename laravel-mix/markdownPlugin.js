const mix = require('laravel-mix');

class MarkdownPlugin {
    register(...args) {
        mix
            .js('vendor/arkecosystem/foundation/resources/assets/js/markdown-editor/markdown-editor.js', 'public/js/markdown-editor.js')
            .postCss('vendor/arkecosystem/foundation/resources/assets/css/markdown-editor.css', 'public/css', [
                require('postcss-import'),
                require('tailwindcss'),
            ])
    }

    webpackConfig(webpackConfig) {
        const  index = webpackConfig.plugins.findIndex(plugin => this.isWebpackNotifierPlugin(plugin));

        if (index <= -1) {
            return;
        }

        webpackConfig.plugins[index].options.excludeWarnings = true;

        if (!webpackConfig.stats.warningsFilter) {
            webpackConfig.stats.warningsFilter = [];
        }

        webpackConfig.stats.warningsFilter.push(/@charset must precede all other statements/);
    }

    isWebpackNotifierPlugin(plugin)
    {
        if (plugin.constructor.name === 'WebpackNotifierPlugin') {
            return true;
        }

        return !! (plugin.options && plugin.options.alwaysNotify);
    }
}

mix.extend('markdown', new MarkdownPlugin());
