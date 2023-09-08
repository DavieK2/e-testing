<script>
    import { createEventDispatcher } from "svelte";
    import Select from "../../components/select.svelte";
    import Button from "../../components/button.svelte";
    import Icons from "../../components/icons.svelte";

    export let headings;
    export let options;

    const dispatch = createEventDispatcher();

</script>

<div class="flex flex-col px-3 pb-5">
    <div class="flex items-center space-x-3 mb-8">
        <button on:click={ () => dispatch('back-button') }>
            <Icons icon="back_arrow" />
        </button>
        <h1 class="font-bold text-lg text-gray-800">Map Questions</h1>
    </div>
    <div class="p-6 border rounded-lg">
        <div class="grid grid-cols-3 w-full text-sm shrink-0 gap-6 font-semibold pb-3 border-b" >
            <div>Headings</div>
            <div>Values</div>
            <div>Mapping</div>
        </div>
        <div class="grid grid-cols-3 w-full text-sm shrink-0 gap-6 text-gray-700 mt-4" >
            <div class="flex flex-col mb-6">
               { #each Object.keys(headings) as heading }
                    <div class="flex flex-col justify-center break-words h-16">{ heading }</div>
               {/each}
            </div>
            <div class="flex flex-col mb-6">
                { #each Object.values(headings) as heading }
                     <div class="flex flex-col justify-center break-all h-16">{ heading.toString().length > 15 ? ( heading.toString().substring( 0, 15 ) + "...") : heading.toString() }</div>
                {/each}
            </div>
            <div class="flex flex-col">
                { #each Object.values(headings) as heading, index }
                     <div class="flex flex-col justify-center break-all h-16">
                        <Select on:deselected={ (e) => dispatch('deselected', { ...e.detail, index, deselected: true }) } on:selected={ (e) => dispatch('selected', { ...e.detail, index, selected: true }) } placeholder="Select Field" { options } />
                     </div>
                {/each}
            </div>
        </div>
    </div>
    <div class="mt-10 min-w-max">
        <Button on:click={ () => dispatch('import') } buttonText="Import Questions" />
    </div>
</div>