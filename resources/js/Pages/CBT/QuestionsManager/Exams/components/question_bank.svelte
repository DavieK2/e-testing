<script>

    import Select from "../../../../../components/select.svelte";
    import { onMount } from "svelte";
    import { inertia } from "@inertiajs/svelte";
    import { router } from "../../../../../../util";
    import DataTable from "../../../../../components/data_table.svelte";


    export let assessmentId;

    let selectedSubject;
    
    let questionBanks = [];
    let subjects = [];

    

    let headings = ['SN', 'SUBJECT', 'TOTAL QUESTIONS', 'LEVELS', 'LECTURER', 'ACTIONS'];


    onMount(() => {

        router.getWithToken('/api/assessment/question-banks/' + assessmentId, {
            onSuccess : (res) => {
                questionBanks = res.data

                console.log( questionBanks );
            }
        });

        getSubjects();
        
    });

    const getSubjects = () => {

        router.getWithToken('/api/question-bank-subjects/' + assessmentId, {
            onSuccess : (res) => {
                subjects = res.data.flatMap((subject) => [ { placeholder: subject.subjectName, value: subject.subjectCode } ])
            }
        });
    }
   


</script>

<div class="w-60 mt-12 mb-6">
    <Select on:selected={ (e) => selectedSubject = e.detail.value } on:deselected={ (e) => selectedSubject = null } options={ subjects } placeholder="Select Subject" className="text-sm" />
</div>


<DataTable { headings }>
    { #each questionBanks as questionBank, index }

        <tr class="border-b">
            <td class="w-4 p-4">
                <div class="flex items-center">
                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                </div>
            </td>
        
            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
            <th scope="row" class="px-4 py-4 text-xs text-gray-600 dark:text-gray-300">{ questionBank.subject  }</th>
            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">{ questionBank.totalQuestions  } Questions</td>
            <td class="px-4 py-4 text-xs text-gray-600 dark:text-gray-300 whitespace-nowrap">
                { #each questionBank.classes as grade }
                    <p>{ grade }</p>
                {/each}
            </td>
            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300">{ questionBank.teacher  }</td>
            <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                <a use:inertia href={ `/assessment/questions/question-bank/${ questionBank.questionBankId }` } class="text-white bg-gray-800 rounded-lg text-sm p-2.5">View Questions</a>
            </td>
           
        </tr>

    {/each}
</DataTable>