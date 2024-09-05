<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import { router } from "../../../util";
    import TopHeader from "../../layouts/top_header.svelte";
    import AppContainer from "../../layouts/app_container.svelte";


    let headings = ['SN', 'Term', 'Actions']

    let terms = []

    let term = "";
    let termId;

    let disabled = false;

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

        disabled = false;
    }
    const getTermList = () => {

        router.get('/api/terms', {
            onSuccess : (response) => {
               terms = response.data
            }
        })
    }

    const createTerm = () => {

        disabled = true;

        router.post('/api/term/create', { term  }, {
            onSuccess: (response) => {
                
                getTermList();
                closeSheet();
                reset();

                disabled = false;

            },
            onError: (response) => {

                disabled = false;
                // console.log(response)
            }
        })
    }

    const updateTerm = () => {

        disabled = true;

        router.post(`/api/term/update/${termId}`, { term }, {
            onSuccess: (response) => {
                
                getTermList();
                closeSheet();
                reset();

                disabled = false;

            },
            onError: (response) => {

                disabled = false;
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

    $: disabled = ( term.length === 0 );

</script>


<Layout>
    <SlidePanel  title="Create New Term" showSheet={ showCreateSheet } on:onpanelstatus={ closeSheet }>
        <TopHeader title="Terms" >
            <div>
                <Button on:click={ showSheet } buttonText="New Terms" className="text-sm" />
            </div>
        </TopHeader>

        <AppContainer>
        
            <DataTable { headings } >
                { #each terms as term,index(term.id) }
                    <tr>
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
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
        
        </AppContainer>

        <div slot="panel">
            <div class="flex flex-col space-y-6 p-3">
                <div>
                    <Input value={ term } on:input={ (e) => term =  e.detail.input } label="Enter Term Title" placeholder="First Term" />
                </div>
                <div class="w-20">
                    { #if termId }
                        <Button { disabled } on:click={ updateTerm } buttonText="Update Term" className="text-sm"/>
                    { :else }
                        <Button { disabled } on:click={ createTerm } buttonText="Save Term" className="text-sm"/>
                    {/if}
                   
                </div>
            </div>
    </SlidePanel>
</Layout>