<script>
    import { onMount } from "svelte";
    import Button from "../../../components/button.svelte";
    import DataTable from "../../../components/data_table.svelte";
    import Input from "../../../components/input.svelte";
    import SlidePanel from "../../../components/slide_panel.svelte";
    import Layout from "../../../layouts/Layout.svelte";
    import { router } from "../../../../util";
    import { toast } from "svelte-sonner";



    let headings = ['SN', 'Session', 'Terms', 'Actions']

    let sessions = [];
    let terms = ['First Term', 'Second Term', 'Third Term'];

    let session = "";
    let sessionId;

    let disabled = false;

    
    onMount( () => {

        getAcademicSessionist();

    })

    let showCreateSheet = false;

    const closeSheet = () => {
        showCreateSheet = false
        reset();
    }

    const showSheet = () => showCreateSheet = true

    const reset = () => {
        sessionId = undefined;
        session = "";

        disabled = false;
    }
    const getAcademicSessionist = () => {

        router.get('/api/sessions', {
            onSuccess : (response) => {
               sessions = response.data
            }
        })
    }

    const createSession = () => {

        disabled = true;

        router.post('/api/session/create', { session }, {
            onSuccess: (response) => {
                
                getAcademicSessionist();
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

    const updateSession = () => {

        disabled = true;

        router.post(`/api/session/update/${sessionId}`, { session }, {
            onSuccess: (response) => {
                
                getAcademicSessionist();
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

    const editSession = (id, name) => {
        sessionId = id
        session = name
        showSheet();
    }

    const deleteSession = (id, name) => {
        sessionId = id
        session = name
    }

    $: disabled = ( session.length === 0 );

</script>
<Layout>
    <SlidePanel showSheet={ showCreateSheet } title={ sessionId ? "Edit Session" : "Create New Session" } on:onpanelstatus={ (e) => showCreateSheet = e.detail.status }>
        
        <div class="flex items-center justify-between bg-white py-4 container border-b">
            <div class="flex space-x-3 items-center">
                <span class="mx-2 text-xl font-bold text-gray-800">Sessions</span>
            </div>
            <div>   
                <Button on:click={ showSheet } buttonText="New Session" className="text-sm" />   
            </div>
        </div>
        <div class="container py-12">
            <DataTable { headings } >
                { #each sessions as session,index(session.id) }
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-4 py-4 text-gray-800 whitespace-nowrap dark:text-white">
                            { index + 1 }
                        </th>
                        <td class="px-4 py-4 text-gray-800 whitespace-nowrap dark:text-white">{ session.session }</td>
                        <td class="px-4 py-4 text-gray-800 whitespace-nowrap dark:text-white">{ session.session }</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                            <div class="flex space-x-3">
                                <Button on:click={ () => router.navigateTo(`/academic-session/${session.id}`) } buttonText="Session Details" className="text-sm bg-white text-gray-800 focus:bg-transparent focus:ring-gray-50 hover:bg-transparent border-2 border-gray-800" />
                                <Button on:click={ () => editSession(session.id, session.session) } buttonText="Edit" className="text-xs min-w-max max-w-min" />
                                <Button on:click={ () =>  toast('Success') } buttonText="Delete" className="text-xs min-w-max max-w-min bg-red-500 hover:bg-red-400 focus:bg-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50" />
                            </div>
                        </td>
                    </tr>
                { /each }
            </DataTable>
            

        </div>


        
        <div slot="panel">
            <div class="flex flex-col space-y-6 w-80 py-8">
                <div>
                    <Input id="title" value={ session } on:input={ (e) => session = e.detail.input } label="Enter Session Title" placeholder="2022/2023" />
                </div>

                <div class="pt-3">
                    <label for="" class="font-medium text-gray-700">Select Academic Session Terms</label>
                    { #each terms as  term }
                        <div class="pt-3 flex items-center space-x-2">
                            <input type="checkbox" name="" id="">
                            <span class="text-gray-700">{ term }</span>
                        </div>
                    { /each }
                </div>
                <div class="w-20">
                    { #if sessionId }
                        <Button { disabled } on:click={ updateSession } buttonText="Update Session" className="text-sm"/>
                    { :else }
                        <Button { disabled } on:click={ createSession } buttonText="Save Session" className="text-sm"/>
                    {/if}
                
                </div>
            </div>
        </div>

    </SlidePanel>
</Layout>