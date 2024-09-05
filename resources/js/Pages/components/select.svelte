<svelte:options accessors />

<script>
    import { createEventDispatcher, onMount } from "svelte";
    import Icons from "./icons.svelte";
    import { cn } from "./utils";

    export let label = "";
    export let value = null;
    export let placeholder;
    export let className = '';
    export let optionsStyling = '';
    export let placeholderStyling = '';
    export let options = [];
    export let disabled = false;
    export let isSelected = false;
    export let labelStyle = '';

    let initialValues = {}

    let dropDown;
    let showDropdown = false

    const dispatch = createEventDispatcher();

    onMount(() => {

        initialValues['placeholder'] = placeholder
        initialValues['isSelected'] = isSelected
        initialValues['value'] = value

    })

    const onSelect = (placeholderParam, valueParam) => {

        placeholder = placeholderParam;
        value = valueParam;

        dropDown.blur();
        showDropdown = false;
        isSelected = true;

        dispatch('selected', { value, placeholder });

    }

    const reset = () => {
        
        dispatch('deselected', { value, placeholder });

        placeholder = initialValues.placeholder
        isSelected = initialValues.isSelected
        value = initialValues.value

    }
  
    const show = () => showDropdown = true
    const hide = () => showDropdown = false

    $: {
        
        if( value || value?.length > 0 ){
            

            let placeholderParam = options.filter((option) => option.value === value );
            
            if( placeholderParam[0] ){

                placeholder = placeholderParam[0].placeholder;
                value = value;
                isSelected = true;
            }
           
        }

        // if( options.length === 0 && value ){

        //     placeholder = initialValues.placeholder
        //     isSelected = initialValues.isSelected
        //     value = initialValues.value
            
        // }
    }

</script>
  
<div class="space-y-3 w-full">
   { #if label }
        <label for="" class={ cn(`text-sm text-gray-700`, labelStyle) }>{ label }</label>
   {/if}
    <button bind:this={ dropDown } { disabled }  on:focus={ show } on:focusout={ hide } name="" class={ cn(`relative flex flex-col w-full rounded-lg border-0 py-2 px-2.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-inset focus:ring-gray-800 text-xs sm:leading-6`, className ) }>
        <div class="flex grow-0 items-center justify-between space-x-2 w-full">
            <option class={ cn(`text-left capitalize overflow-hidden ${isSelected ? 'text-gray-700' : 'text-gray-400'}`, placeholderStyling) } >{ placeholder }</option>
            <div class="flex items-center space-x-1">
                { #if isSelected }
                   <!-- svelte-ignore a11y-click-events-have-key-events -->
                   <!-- svelte-ignore a11y-no-static-element-interactions -->
                   <div on:click={ reset } class="isolate">
                        <Icons icon="close" className="h-4 w-4 stroke-red-500"/>
                   </div>
                {/if}
                { #if showDropdown }
                    <Icons icon="chevron_up" className="fill-gray-500" />
                { :else }
                    <Icons icon="chevron_down" className="fill-gray-500" />
                { /if }
            </div>
        </div>

        { #if showDropdown }
            <div class="absolute inset-0 flex flex-col items-start p-3 w-full min-h-max max-h-80  bg-white border border-gray-300 rounded-lg mt-12 z-50">
                <div class="flex flex-col h-full w-full overflow-y-auto">
                    { #if options.length == 0 }
                        <div class="text-left text-xs text-gray-700 rounded p-2 w-full">No Selectable Item</div>
                    { :else }
                        { #each options as option }
                            <!-- svelte-ignore a11y-click-events-have-key-events -->
                            <!-- svelte-ignore a11y-no-static-element-interactions -->
                            <div  on:click={ () => onSelect(option.placeholder, option.value) } class={ cn(`capitalize text-left text-sm text-gray-700 rounded p-2 hover:bg-gray-100/70 transition break-normal`, optionsStyling) }>
                                { option.placeholder }
                            </div>
                        { /each }
                    {/if}
                    
                </div>
            </div>
        { /if }
    </button>  
</div>
  
