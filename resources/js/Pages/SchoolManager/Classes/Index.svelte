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
    import TopHeader from "../../layouts/top_header.svelte";
    import AppContainer from "../../layouts/app_container.svelte";


    let headings = ['SN', 'Level', 'Total Students', 'Actions']

    let classes = [];
    let subjects = [];

    let disabled = false;

    let selectedSubjects = []

    let className = "";
    let classId;

    let assignSubjects = false

    let slideTitle = "Create New Level";

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
        disabled = false;
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

        disabled = true;

        router.post('/api/class/create', { className }, {
            onSuccess: (response) => {
                
                getClassList();
                closeSlidePanel();
                reset();

                disabled = false;

            },
            onError: (response) => {

                disabled = false;
                // console.log(response)
            }
        })
    }

    const addClassSubjects = (id) => {

        disabled = true;

        classId = id;

        router.get('/api/class/subjects/' + id, {
            onSuccess: (response) => {
                
                assignSubjects  = true
                selectedSubjects = response.data
                showSheet()

                disabled = false;

            },
            onError: (response) => {

                disabled = false;
                // console.log(response) 
            }
        })
    }

    const updateClass = () => {

        disabled = true;

        router.post('/api/class/update/'+classId, { className }, {
            onSuccess: (response) => {
                
                getClassList();
                closeSlidePanel();
                reset();

                disabled = false;

            },
            onError: (response) => {
                disabled = false;
                // console.log(response)
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

        disabled = true;

        let subjectIds = selectedSubjects.flatMap( (subject) => [ subject.subjectId ])

        router.post('/api/class/assign-subjects/'+classId, { subjects: subjectIds }, {
            
            onSuccess : (res) => {

                closeSlidePanel();

                disabled = false;
            }
        } )
    }

    const deleteClass = (id, name) => {
        classId = id
        className = name
    }

    $: disabled = ( assignSubjects && selectedSubjects.length === 0 ) || ( ! assignSubjects && className.length === 0 )

</script>
<Layout>
    <SlidePanel title={ slideTitle } showSheet={ isSlidePanelOpen } on:onpanelstatus={closeSlidePanel }>
        <TopHeader title="Classes" >
            <div>
                <Button on:click={ showSheet } buttonText="New Class" className="text-sm" />
            </div>
        </TopHeader>

        <AppContainer>
        
            <DataTable { headings } >
                { #each classes as grade,index(grade.class_code) }
                    <tr>
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ grade.class_name }</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ grade.studentCount ?? 'Not Available'}</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                            <div class="w-40">
                                <Dropdown arrowColor="fill-gray-600" placeholder="Actions" className="bg-white border  border-gray-300 text-gray-600">
                                    <button on:click={ () => editClass(grade.id, grade.class_name) } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Edit Level</button>
                                    <button on:click={ () => addClassSubjects(grade.id)} class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Add Courses</button>
                                </Dropdown>
                            </div>
                        </td>
                    </tr>
                { /each }
            </DataTable>
        
        </AppContainer>

        <div slot="panel">
            { #if assignSubjects }
                <div class="flex flex-col space-y-3 p-3">
                    <p class="text-gray-800 font-semibold pb-6">Assign Courses</p>

                    <div class="space-y-3">
                        { #each subjects as subject}
                            <div class="flex space-x-2 items-center w-full">
                                <button  on:click={ () => selectSubject(subject) } class={`flex items-center shrink-0 justify-center h-[3.2rem] w-[3.2rem] border-2 ${ isSelected(subject.subjectId) ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                    <Icons icon="check" className={`${ isSelected(subject.subjectId) ? "stroke-green-700" : "stroke-gray-300" }`} />
                                </button>
                                <div class="w-full">
                                    <button type="button" class={`flex p-3 border-2 ${ isSelected(subject.subjectId) ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                        <span class={`${ isSelected(subject.subjectId) ? "text-green-700" : "text-gray-400" }`} >{ subject.subjectName }</span>
                                    </button>
                                </div>
                            </div>
                        {/each}
                    </div>

                    <div class="pt-10">
                        <Button { disabled } on:click={ assignSubjectsToClass } buttonText="Assign Courses" />
                    </div>
                </div>
            { :else }
                <div class="flex flex-col space-y-6 p-3">
                    <div>
                        <Input value={ className } on:input={ (e) => className = e.detail.input }  label="Enter Class Name" />
                    </div>
                    <div class="w-20">
                        { #if classId }
                            <Button { disabled } on:click={ updateClass } buttonText="Update Class" className="text-sm"/>
                        { :else }
                            <Button { disabled } on:click={ createClass } buttonText="Save Class" className="text-sm"/>
                        {/if}
                    
                    </div>
                </div>
            { /if }
    </SlidePanel>
</Layout>