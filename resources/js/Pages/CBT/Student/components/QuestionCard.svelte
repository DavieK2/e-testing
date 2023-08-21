<script>
    import Icons from "../../../components/icons.svelte";
    import { createEventDispatcher } from "svelte";

    export let questionNumber;
    export let question = {};

    const dispatch = createEventDispatcher();

</script>

<div class="flex flex-col px-8 pt-8 pb-4">
    <div class="pb-6">
        <div class="space-y-4 pb-3">
           <div class="flex items-center justify-between">
                <p class="text-gray-400 font-semibold text-lg">Question { questionNumber }</p>
           </div>
            <p class="text-gray-800 text-sm font-base">{ question.prompt }</p>
        </div>
        <ul class="flex flex-col w-full space-y-2 text-sm text-gray-600 pt-8">
            { #each question.choices ?? [] as option }
                <div class="flex space-x-2 items-center w-full">
                    <button  on:click={ () => dispatch('selected', { questionId : question.questionId }) } class={`flex items-center shrink-0 justify-center h-11 w-11 border ${ option == question.selected ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                        <Icons icon="check" className={`${ option == question.selected ? "stroke-green-700" : "stroke-gray-300" }`} />
                    </button>
                    <div class="w-full">
                        <button type="button" class={`flex p-3 border ${ option == question.selected ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                            <span class={`${ option == question.selected ? "text-green-700" : "text-gray-400" }`} >{ "Test" }</span>
                        </button>
                    </div>
                </div>
            { /each }
        </ul>
       <slot></slot>
    </div>
</div>