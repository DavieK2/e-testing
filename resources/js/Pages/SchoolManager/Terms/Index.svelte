<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import { router } from "../../../util";


    let headings = ['SN', 'Term', 'Actions']

    let terms = []

    let termInput;
    let term = "";
    let termId;

    onMount( () => {

        getTermList();

    })

    let showCreateSheet = false;

    const closeSheet = () => {
        showCreateSheet = false
        reset();
    }

    const showSheet = () => showCreateSheet = true

    const reset = () => {
        termId = undefined;
        term = "";
    }
    const getTermList = () => {

        router.get('/api/terms', {
            onSuccess : (response) => {
               terms = response.data
            }
        })
    }

    const createTerm = () => {

        router.post('/api/term/create', { term : termInput.value }, {
            onSuccess: (response) => {
                
                getTermList();
                closeSheet();
                reset();

            },
            onError: (response) => {
                // console.log(response)
            }
        })
    }

    const updateTerm = () => {

        router.post('/api/term/update', { term : termInput.value, termId }, {
            onSuccess: (response) => {
                
                getTermList();
                closeSheet();
                reset();

            },
            onError: (response) => {
                // console.log(response)
            }
        })
    }

    const editTerm = (id, name) => {
        termId = id
        term = name
        showSheet();
    }

    const deleteClass = (id, name) => {
        termId = id
        term = name
    }


</script>
<Layout>
    <div class="my-28 px-6">
        <div class="container px-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex space-x-3 items-center">
                    <Icons icon="schedule" classList="h-8 w-8" />
                    <span class="mx-2 text-2xl font-semibold text-gray-800">Terms</span>
                </div>
                <div>
                    <Button on:click={ showSheet } buttonText="Create New Term" className="text-sm" />
                </div>
            </div>
        </div>
        <DataTable { headings } >
            { #each terms as term,index(term.id) }
                <tr>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ term.term }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                        <div class="flex space-x-3">
                            <Button on:click={ () => editTerm(term.id, term.term) } buttonText="Edit" className="text-xs w-20" />
                            <Button buttonText="Delete" className="text-xs w-20 bg-red-500 hover:bg-red-400 focus:bg-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50" />
                        </div>
                    </td>
                </tr>
            { /each }
        </DataTable>
    </div>
</Layout>

<SlidePanel title="Create New Term" showSheet={ showCreateSheet } on:close-button={ closeSheet } >
    <div class="flex flex-col space-y-6 p-3">
        <div>
            <Input value={ term } bind:this={ termInput }  label="Enter Term Title" />
        </div>
        <div class="w-20">
            { #if termId }
                <Button on:click={ updateTerm } buttonText="Update" className="text-sm"/>
            { :else }
                <Button on:click={ createTerm } buttonText="Save" className="text-sm"/>
            {/if}
           
        </div>
    </div>
</SlidePanel>