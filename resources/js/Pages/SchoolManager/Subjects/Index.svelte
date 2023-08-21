<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import { router } from "../../../util";


    let headings = ['SN', 'Subject Name', 'Actions'];

    let subjects = []

    let subjectInput;
    let subjectName = "";
    let subjectId;

    onMount( () => {

        getSubjectList();

    })

    let showCreateSubjectSheet = false;

    const closeSheet = () => {
        showCreateSubjectSheet = false
        reset();
    }

    const showSheet = () => showCreateSubjectSheet = true

    const reset = () => {
        subjectId = undefined;
        subjectName = "";
    }

    const getSubjectList = () => {

        router.get('/api/subjects', {
            onSuccess : (response) => {
               subjects = response.data
            }
        })
    }

    const createSubject = () => {

        router.post('/api/subject/create', { subjectName : subjectInput.value }, {
            onSuccess: (response) => {
                
                getSubjectList();
                reset();
                closeSheet();

            },
            onError: (response) => {
                // console.log(response)
            }
        })
    }

    const updateSubject = () => {

        router.post('/api/subject/update', { subjectName : subjectInput.value, subjectId }, {
            onSuccess: (response) => {

                getSubjectList();
                reset();
                closeSheet();

            },
            onError: (response) => {
                // console.log(response)
            }
        })
    }

    const editSubject = (id, name) => {
        subjectId = id
        subjectName = name
        showSheet();
    }

    const deleteSubject = (id, name) => {
        subjectId = id
        subjectName = name
    }

</script>
<Layout>
    <div class="mt-28 px-3">
        <div class="container px-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex space-x-3 items-center">
                    <Icons icon="book" className="h-8 w-8" />
                    <span class="mx-2 text-xl font-medium text-gray-800">Subjects</span>
                </div>
                <div>
                    <Button on:click={ showSheet } buttonText="Create New Subject" className="text-sm" />
                </div>
            </div>
        </div>
        <DataTable { headings } >
            { #each subjects as subject,index(subject.subjectId) }
                <tr>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ subject.subjectName }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                        <div class="flex space-x-3">
                            <Button on:click={ () => editSubject(subject.subjectId, subject.subjectName) } buttonText="Edit" className="text-xs w-20" />
                            <Button buttonText="Delete" className="text-xs w-20 bg-red-500 hover:bg-red-400 focus:bg-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50" />
                        </div>
                    </td>
                </tr>
            {/each}
        </DataTable>
    </div>
</Layout>

<SlidePanel title="Create New Subject" showSheet={ showCreateSubjectSheet } on:close-button={ closeSheet }>
    <div class="flex flex-col space-y-6 p-3">
        <div>
            <Input value={ subjectName } bind:this={ subjectInput }  label="Enter Subject Name" />
        </div>
        <div class="w-20">
            { #if subjectId }
                <Button on:click={ updateSubject } buttonText="Update" className="text-sm"/>
            { :else }
                <Button on:click={ createSubject } buttonText="Save" className="text-sm"/>
            { /if }
        </div>
    </div>
</SlidePanel>