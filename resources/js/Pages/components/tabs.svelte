<script>
    import { createEventDispatcher } from "svelte";
    import { cn } from "./utils";

    export let tabs = [];
    export let currentTab = ''
    export let className = '';

    const dispatch = createEventDispatcher();

</script>


<div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px">
        { #each tabs as tab }
            <li class="me-2">
                <button on:click={ () => dispatch('tab-change', { tab }) } type="button" class={ cn(`${ tab === currentTab ? 'text-gray-800 border-gray-800 dark:text-gray-800 dark:border-gray-800' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'} inline-block p-4 border-b-2  rounded-t-lg`, className)}>{ tab }</button>
            </li>
        { /each }
        
        
    </ul>
</div>