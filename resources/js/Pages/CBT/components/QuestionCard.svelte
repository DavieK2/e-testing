<script>
    export let questionNumber;
    export let question;
    export let questionOptions = []
    export let correctAnswer;
    export let questionScore
</script>

<div class="flex flex-col px-8 pt-8 pb-4 w-full">
    <div class="border-b pb-6">
        <div class="space-y-4 pb-3">
           <div class="flex items-center justify-between">
                <p class="text-gray-400 font-semibold text-xs">Question { questionNumber }</p>
                <p class="text-gray-400 font-semibold text-xs">( { questionScore } Marks )</p>
           </div>
            <p class="text-gray-800 text-sm font-medium">{ question }</p>
        </div>
        <ul class="flex flex-col w-full space-y-2 text-xs text-gray-600 pt-4">
            { #each questionOptions as option }
                { #if option == correctAnswer }
                    <div class="flex p-3 border border-green-500 w-full rounded-lg items-center justify-between space-x-2">
                        <li class="text-green-500">{ option }</li>
                        <small class="text-green-500">(Correct Answer)</small>
                    </div>
                { :else }
                    <li class="p-3 border w-full rounded-lg">{ option }</li>
                { /if }
            {/each}
        </ul>
       <slot></slot>
    </div>
</div>