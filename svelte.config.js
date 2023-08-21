import sveltePreprocess from 'svelte-preprocess';

const config = {
    preprocess: sveltePreprocess(),
    shadcn: {
        componentPath: './resources/js/components/ui'
    }
};
export default config;
