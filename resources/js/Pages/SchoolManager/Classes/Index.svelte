<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import { router } from "../../../util";
    import Dropdown from "../../components/dropdown.svelte";


    let headings = ['SN', 'Class Name', 'Total Students', 'Actions']

    let classes = [];
    let subjects = [];

    let selectedSubjects = []

    let classInput;
    let className = "";
    let classId;

    let assignSubjects = false

    let slideTitle = "Create New Class";

    onMount( () => {

        getClassList();
        getSubjectList();

    })

    let isSlidePanelOpen = false;

    const closeSlidePanel = () => {
        isSlidePanelOpen = false
        reset();
    }

    const showSheet = () => isSlidePanelOpen = true

    const reset = () => {
        classId = undefined;
        className = "";
        assignSubjects = false
    }

    $: isSelected = (subjectId) => {
        return selectedSubjects.some((selected) => selected.subjectId == subjectId);
    }

    const getClassList = () => {

        router.get('/api/classes', {
            onSuccess : (response) => {
               classes = response.data
            }
        })
    }

    const getSubjectList = () => {

        router.get('/api/subjects', {
            onSuccess : (response) => {
               subjects = response.data
            }
        })
    }

    const createClass = () => {

        router.post('/api/class/create', { className : classInput.value }, {
            onSuccess: (response) => {
                
                getClassList();
                closeSlidePanel();
                reset();

            },
            onError: (response) => {
                // console.log(response)
            }
        })
    }

    const addClassSubjects = (id) => {

        classId = id;

        router.get('/api/class/subject/' + id, {
            onSuccess: (response) => {
                
                assignSubjects  = true
                selectedSubjects = response.data
                showSheet()

            },
            onError: (response) => {
                console.log(response)
            }
        })
    }

    const updateClass = () => {

        router.post('/api/class/update', { className : classInput.value, classId }, {
            onSuccess: (response) => {
                
                getClassList();
                closeSlidePanel();
                reset();

            },
            onError: (response) => {
                console.log(response)
            }
        })
    }

    const editClass = (id, name) => {
        classId = id
        className = name
        slideTitle = "Edit Class"
        showSheet();
    }

    const selectSubject = (subject) => {

        if(isSelected(subject.subjectId)){
            selectedSubjects = selectedSubjects.filter((selected) => selected.subjectId != subject.subjectId);
            return ;
        }

        selectedSubjects.push(subject);
        selectedSubjects = selectedSubjects;

    }

    const assignSubjectsToClass = () => {

        router.post('/api/class/assign-subjects', { classId, subjects: selectedSubjects }, {
            onSuccess : (res) => {
                closeSlidePanel();
            }
        } )
    }

    const deleteClass = (id, name) => {
        classId = id
        className = name
    }


</script>
<Layout>
    <div class="my-28 px-6">
        <div class="container px-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex space-x-3 items-center">
                    <Icons icon="badge" className="h-8 w-8" />
                    <span class="mx-2 text-2xl font-semibold text-gray-800">Classes</span>
                </div>
                <div>
                    <Button on:click={ showSheet } buttonText="Create New Class" className="text-sm" />
                </div>
            </div>
        </div>
        <DataTable { headings } >
            { #each classes as grade,index(grade.class_code) }
                <tr>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ grade.class_name }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ grade.studentCount ?? 'Not Available'}</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                        <div class="w-40">
                            <Dropdown arrowColor="fill-gray-600" placeholder="Actions" className="bg-white border  border-gray-300 text-gray-600">
                                <button on:click={ () => editClass(grade.id, grade.class_name) } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Edit Class</button>
                                <button on:click={ () => addClassSubjects(grade.id)} class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Add Subjects</button>
                            </Dropdown>
                        </div>
                    </td>
                </tr>
            { /each }
        </DataTable>
    </div>
</Layout>

<SlidePanel title={ slideTitle } showSheet={ isSlidePanelOpen } on:close-button={ closeSlidePanel } >
    { #if assignSubjects }
        <div class="flex flex-col space-y-3 p-3">
            <p class="text-gray-800 font-semibold pb-6">Assign Subjects</p>

            <div class="space-y-3">
                { #each subjects as subject}
                    <div class="flex space-x-2 items-center w-full">
                        <button  on:click={ () => selectSubject(subject) } class={`flex items-center shrink-0 justify-center h-11 w-11 border ${ isSelected(subject.subjectId) ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                            <Icons icon="check" className={`${ isSelected(subject.subjectId) ? "stroke-green-700" : "stroke-gray-300" }`} />
                        </button>
                        <div class="w-full">
                            <button type="button" class={`flex p-3 border ${ isSelected(subject.subjectId) ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                <span class={`${ isSelected(subject.subjectId) ? "text-green-700" : "text-gray-400" }`} >{ subject.subjectName }</span>
                            </button>
                        </div>
                    </div>
                {/each}
            </div>

            <div class="pt-10">
                <Button on:click={ assignSubjectsToClass } buttonText="Assign Subjects" />
            </div>
        </div>
    { :else }
        <div class="flex flex-col space-y-6 p-3">
            <div>
                <Input value={ className } bind:this={ classInput }  label="Enter Class Name" />
            </div>
            <div class="w-20">
                { #if classId }
                    <Button on:click={ updateClass } buttonText="Update" className="text-sm"/>
                { :else }
                    <Button on:click={ createClass } buttonText="Save" className="text-sm"/>
                {/if}
            
            </div>
        </div>
    { /if }
</SlidePanel>