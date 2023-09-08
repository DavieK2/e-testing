<script>
    import { router } from "../../../util";
    import { createEventDispatcher } from "svelte";
    import { page } from "@inertiajs/svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";


    export let edit = false;

    export let correctAnswer = ""; 
    export let options = [];
    export let questionScore = "";
    export let question = "";
    export let questionId;
    export let source;
    export let classId;
    export let subjectId;

    let questionInput;
    let assessmentId = $page.props.assessmentId

    const dispatch = createEventDispatcher();

    const setCorrectAnswer = (answer) => correctAnswer = answer; 

    const addOption = () => {
        options.push("");
        options = options
    }

    const setOptionValue = (input, index) => {
        options[index] = input;
    }

    const removeOption = (key) => {
        options = options.filter((opt, index) => index != key );
    }

    const updateQuestion = () => {

        let data = {
            question,
            questionId,
            options,
            correctAnswer,
            questionScore,
            source
        }
        router.post('/api/question/update/'+ assessmentId, data, {
            onSuccess : (response) => {
                dispatch('updated', { question : data });
            },
            onError : (response) => {
                console.log(response);
            }
        })
    }

    const saveQuestion = () => {

        let data = {
            question,
            options,
            correctAnswer,
            questionScore,
        }

        router.post('/api/question/create/'+ assessmentId, { ...data, subjectId, classId }, {
            onSuccess : (response) => {
                data.questionId = response.data.questionId;
                dispatch('saved', { question : data });
            },
            onError : (response) => {
                console.log(response);
            }
        })
    }

    const onQuestionInput = (e) => question = e.target.value;

    $: isCorrectAnswer = (option) => option.length > 0 && option === correctAnswer;

</script>

<div class="flex flex-col px-3 pt-8 pb-4">
    <div class="pb-6">
        <div class="space-y-4 pb-3">
            <p class="text-gray-800 font-semibold text-sm">Question</p>
            <textarea on:input={ (e) => onQuestionInput(e)  } bind:this={ questionInput } class="border-0 w-full focus:outline-none ring-1 ring-gray-300 focus:ring-gray-500 rounded-lg resize-none p-4 border-gray-300 text-gray-800 text-sm text-left" cols="30" rows="5">{ question }</textarea>
        </div>
        <p class="text-gray-800 font-semibold text-sm">Options</p>
        <ul class="flex flex-col w-full space-y-2 text-xs text-gray-600 pt-2">
            { #each options as option,index }
                <div class="flex space-x-2 items-center w-full">
                    <button on:click={ () => setCorrectAnswer(option) } class={`flex items-center shrink-0 justify-center h-11 w-11 border ${ isCorrectAnswer(option) ? 'border-green-500' : 'border-gray-300' } rounded-lg`}>
                        <Icons icon="check" className={ isCorrectAnswer(option)  ? 'stroke-green-500' : 'stroke-gray-400'} />
                    </button>
                    <div class="w-full">
                        <Input on:input={ (e) => setOptionValue(e.detail.input, index) }  value={ option } className={ isCorrectAnswer(option)  ? "ring-green-400 text-green-500" : "ring-gray-300" } />
                    </div>
                    { #if (index + 1) == options.length }
                        <button on:click={ addOption } class={`flex items-center shrink-0 justify-center h-11 w-11 border ${ isCorrectAnswer(option) ? 'border-green-500' : 'border-gray-300' } rounded-lg`}>
                            <Icons icon="plus" className={ isCorrectAnswer(option)  ? 'stroke-green-500' : 'stroke-gray-400'} />
                        </button>
                    {/if}

                    { #if index > 1 }
                        <button on:click={ () => removeOption(index) } class={`flex items-center shrink-0 justify-center h-11 w-11 border ${ isCorrectAnswer(option) ? 'border-green-500' : 'border-gray-300' } rounded-lg`}>
                            <Icons icon="trash" className={ isCorrectAnswer(option)  ? 'stroke-green-500' : 'stroke-gray-400'} />
                        </button>
                    {/if}
                </div>
            {/each}
        </ul>
        <div class="w-32 mt-6 space-y-2">
            <p class="text-gray-800 font-semibold text-sm ">Question Score</p>
            <Input on:input={ (e) => questionScore = e.detail.input } value={ questionScore }  />
        </div>
        <div class="flex space-x-2 pt-5">
            <button on:click={ () => dispatch('cancel') } class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm">Cancel</button>
            { #if edit }
                <button on:click={ updateQuestion } class="px-4 py-2.5 bg-gray-800 text-gray-50 rounded-lg text-sm">Update Question</button>
            { :else }   
                <button on:click={ saveQuestion } class="px-4 py-2.5 bg-gray-800 text-gray-50 rounded-lg text-sm">Save Question</button>
            {/if}
        </div>
    </div>
</div>