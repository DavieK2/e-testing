<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import { router } from "../../../util";


    let headings = ['SN', 'Session', 'Actions']

    let sessions = []

    let sessionInput;
    let session = "";
    let sessionId;

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
    }
    const getAcademicSessionist = () => {

        router.get('/api/sessions', {
            onSuccess : (response) => {
               sessions = response.data
            }
        })
    }

    const createSession = () => {

        router.post('/api/session/create', { session : sessionInput.value }, {
            onSuccess: (response) => {
                
                getAcademicSessionist();
                closeSheet();
                reset();

            },
            onError: (response) => {
                // console.log(response)
            }
        })
    }

    const updateSession = () => {

        router.post('/api/session/update', { session : sessionInput.value, academicSessionId: sessionId }, {
            onSuccess: (response) => {
                
                getAcademicSessionist();
                closeSheet();
                reset();

            },
            onError: (response) => {
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


</script>
<Layout>
    <div class="my-28 px-6">
        <div class="container px-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex space-x-3 items-center">
                    <Icons icon="update" className="h-6 w-6" />
                    <span class="mx-2 text-lg font-semibold text-gray-800">Sessions</span>
                </div>
                <div>
                    <Button on:click={ showSheet } buttonText="Create New Session" className="text-sm" />
                </div>
            </div>
        </div>
        <DataTable { headings } >
            { #each sessions as session,index(session.id) }
                <tr>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ session.session }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                        <div class="flex space-x-3">
                            <Button on:click={ () => editSession(session.id, session.session) } buttonText="Edit" className="text-xs w-20" />
                            <Button buttonText="Delete" className="text-xs w-20 bg-red-500 hover:bg-red-400 focus:bg-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50" />
                        </div>
                    </td>
                </tr>
            { /each }
        </DataTable>
    </div>
</Layout>

<SlidePanel title="Create New Session" showSheet={ showCreateSheet } on:close-button={ closeSheet } >
    <div class="flex flex-col space-y-6 p-3">
        <div>
            <Input value={ session } bind:this={ sessionInput }  label="Enter Session Title" />
        </div>
        <div class="w-20">
            { #if sessionId }
                <Button on:click={ updateSession } buttonText="Update" className="text-sm"/>
            { :else }
                <Button on:click={ createSession } buttonText="Save" className="text-sm"/>
            {/if}
           
        </div>
    </div>
</SlidePanel>