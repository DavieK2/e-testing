<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import { router } from "../../../util";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Input from "../../components/input.svelte";
    import Dropdown from "../../components/dropdown.svelte";
    import TopHeader from "../../layouts/top_header.svelte";
    import AppContainer from "../../layouts/app_container.svelte";

    let headings = ['S/N', 'Full Name', 'Email', 'Actions'];

    let teachers = [];
    let classes = [];
    let subjects = []

    let disabled = false;

    let selectedSubjects = []
    let selectedClasses = []

    let teacherSubjects = [];
    let teacherClasses = [];

    let classSubjects = {};

    let name;
    let email;
    let phoneNumber;
    let password;

    let slidePanelTitle;
    let slideFormState;

    let teacherData = {
        id : "",
        name : "",
        email : "",
        password : "",
        phoneNumber : ""
    }

    let panelState = {
        addNewTeacher : "Add New Teacher",
        edit : "Edit Teacher Info",
        assignSubjects : "Assign Subject",
        assignClasses : "Assign Class",
        assignClassSubjects : "Assign Class Subjects",
    }

    let showTeacherForm = false;

    const reset = () => {

        teacherData = {
            id : "",
            name : "",
            email : "",
            password: "",
            phoneNumber : ""
        }
    }

    const getTeachers = () => {

        router.get('/api/teachers', {

            onSuccess: (res) => {
                teachers = res.data
            }
        })
    }


    const getClasses = () => {

        router.get('/api/classes', {

            onSuccess: (res) => {
                classes = res.data
            }
        })   
    }

    const getSubjects = () => {

        router.get('/api/subjects', {

            onSuccess: (res) => {
                subjects = res.data
            }
        })
    }


    onMount(() => {

        getTeachers();
        getClasses();
        getSubjects();

    })

    const addNewTeacher = () => {
        
        disabled = true;

        router.post('/api/teacher/create', { name : name.value, phoneNumber : phoneNumber.value, email : email.value, password: password.value }, {

            onSuccess : (res) => {

                getTeachers();
                closeSheet();

                disabled = false;
            }, 
            onError : (res) => {
                
                disabled = false;
            }
        });
    }

    const editTeacherInfo = (index) => {
        
        teacherData.id = teachers[index].id
        teacherData.name = teachers[index].name
        teacherData.email = teachers[index].email
        teacherData.phoneNumber = teachers[index].phoneNumber

        showSheet(panelState.edit);
    }

    const assignSubjects = (index) => {
        
        teacherData.id = teachers[index].id

        router.get(`/api/teacher/assigned-subjects/${teacherData.id}`, {

            onSuccess: (res) => {
                selectedSubjects = res.data
            }
        });
      
        showSheet(panelState.assignSubjects);
    }

    const assignClasses = (index) => {
        
        teacherData.id = teachers[index].id

        router.get(`/api/teacher/assigned-classes/${teacherData.id}`, {

            onSuccess: (res) => {
                selectedClasses = res.data
            }
        });
      
        showSheet(panelState.assignClasses);
    }

    const assignClassSubjects = (index) => {
        
        teacherData.id = teachers[index].id

        router.get(`/api/teacher/assigned-classes/${teacherData.id}`, {

            onSuccess: (res) => {
                teacherClasses = res.data
            }
        });

        router.get(`/api/teacher/assigned-subjects/${teacherData.id}`, {

            onSuccess: (res) => {
                teacherSubjects = res.data
            }
        });

        router.get(`/api/teacher/assigned-class-subjects/${teacherData.id}`, {

            onSuccess: (res) => {

                if( res.data.length === 0 ) {

                    classSubjects = {}
                    return;
                }
                
                classSubjects = res.data
            }
        });
      
        showSheet(panelState.assignClassSubjects);
    }

    const updateTeacherInfo = () => {
        
        disabled = true;

        router.post(`/api/teacher/update/${teacherData.id}`, { name : name.value, phoneNumber : phoneNumber.value, email : email.value, password: password.value }, {

            onSuccess : (res) => {

                getTeachers();
                closeSheet();

                disabled = false;
            }, 
            onError : (res) => {

                disabled = false;
            }
        });
        
    }

    const assignSubjectToTeacher = () => {

        disabled = true;

        let subjectIds = selectedSubjects.flatMap( (subject) => [ subject.subjectId] );

        router.post(`/api/teacher/assign-subjects/${teacherData.id}`, { subjects : subjectIds }, {

            onSuccess : (res) => {

                closeSheet();

                disabled = false;
            }, 
            onError : (res) => {

                disabled = false;
            }

        })
    }

    const assignClassToTeacher = () => {

        disabled = true;

        let classIds = selectedClasses.flatMap((grade) => [ grade.id ]);

        router.post(`/api/teacher/assign-classes/${teacherData.id}`, { classes : classIds }, {

            onSuccess : (res) => {

                closeSheet();

                disabled = false;
            }, 
            onError : (res) => {

                disabled = false;
            }
        })
    }

     const assignClassSubjectsToTeacher = () => {

        disabled = true;

        router.post(`/api/teacher/assign-class-subjects/${teacherData.id}`, { classSubjects }, {

            onSuccess : (res) => {

                closeSheet();

                disabled = false;

            }, 
            onError : (res) => {

                disabled = false;
            }
        })
    }

    const showSheet = (state) => {

        slideFormState = state;
        slidePanelTitle = state;

        showTeacherForm = true
    };

    const closeSheet = () => {

        reset()
        showTeacherForm = false

    };


    $: isSelected = (subjectId) => {
        return selectedSubjects.some((selected) => selected.subjectId == subjectId);
    }

    $: isClassSelected = (id) => {
        return selectedClasses.some((selected) => selected.id == id);
    }

    const selectSubject = (subject) => {

        if(isSelected(subject.subjectId)){
            selectedSubjects = selectedSubjects.filter((selected) => selected.subjectId != subject.subjectId);
            return ;
        }

        selectedSubjects.push(subject);
        selectedSubjects = selectedSubjects;

    }

    const selectClass = (grade) => {

        if(isClassSelected(grade.id)){
            selectedClasses = selectedClasses.filter((selected) => selected.id != grade.id);
            return ;
        }

        selectedClasses.push(grade);
        selectedClasses = selectedClasses;

    }

    const selectClassSubjects = (subIndex, classCode) => {

        let subjectId = teacherSubjects[subIndex]?.subjectId;

        if( isClassSubjectSelected(subjectId, classCode) ){

            classSubjects[subjectId] =  classSubjects[subjectId].filter(( gradeCode) =>  gradeCode != classCode );
   
        } else {

            classSubjects[subjectId] = [  ...(classSubjects[subjectId] ?? []), classCode ];
        }

    }

    $: isClassSubjectSelected = (subjectId, classCode) =>  classSubjects[subjectId]?.some( (gradeCode) => gradeCode === classCode )

    $: disabled = ( (slideFormState === panelState.assignSubjects && subjects.length === 0) || ( slideFormState === panelState.assignSubjects && selectedSubjects.length === 0 ) ) ||
                  ( (slideFormState === panelState.assignClasses && classes.length === 0) || ( slideFormState === panelState.assignClasses && selectedClasses.length === 0 ) ) ||
                  ( (slideFormState === panelState.assignClassSubjects && Object.values(classSubjects).length === 0 ) )

</script>


<Layout>
    <SlidePanel title={ slidePanelTitle } showSheet={ showTeacherForm } on:onpanelstatus={ closeSheet }>
        <TopHeader title="Teachers" >
            <div>
                <Button on:click={ () => showSheet(panelState.addNewTeacher) } buttonText="Add New Teacher" className="text-sm" />
            </div>
        </TopHeader>

        <AppContainer>
        
            <DataTable { headings } >
                { #each teachers as teacher,index(teacher.id) }
                    <tr>
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ teacher.name }</td>
                        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ teacher.email }</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                            <div class="w-40">
                                <Dropdown arrowColor="fill-gray-600" placeholder="Actions" className="bg-white border  border-gray-300 text-gray-600">
                                    <button on:click={ () => editTeacherInfo(index) }  class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Edit</button>
                                    <button on:click={ () => assignSubjects(index) } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Assign Subjects</button>
                                    <button on:click={ () => assignClasses(index) } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Assign Classes</button>
                                    <button on:click={ () => assignClassSubjects(index) } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Assign Class Subjects</button>
                                </Dropdown>
                            </div>
                        </td>
                    </tr>
                { /each }
            </DataTable>
        
        </AppContainer>

        <div slot="panel">
            { #if (slideFormState === panelState.addNewTeacher) || (slideFormState === panelState.edit) }
                <div class="flex flex-col space-y-6 p-3">
                    <div>
                        <Input value={ teacherData.name } bind:this={ name }  label="Enter Teacher's Name" />
                    </div>
                    <div>
                        <Input value={ teacherData.email } bind:this={ email }  label="Enter Teacher's Email" />
                    </div>
                    <div>
                        <Input value={ teacherData.password } bind:this={ password }  label="Enter Teacher's Password" />
                    </div>
                    <div>
                        <Input value={ teacherData.phoneNumber } bind:this={ phoneNumber }  label="Enter Teacher's Phone Number" />
                    </div>
                    <div class="w-20">
                        { #if teacherData.id }
                            <Button { disabled } on:click={  updateTeacherInfo } buttonText="Update" className="text-sm"/>
                        { :else }
                            <Button { disabled } on:click={ addNewTeacher } buttonText="Save" className="text-sm"/>
                        { /if }
                    </div>
                </div>
            { /if }

            { #if (slideFormState === panelState.assignSubjects) }
                <div class="flex flex-col space-y-3 p-3">
                    <p class="text-gray-800 font-semibold pb-6">Subjects</p>

                    <div class="space-y-3">
                        { #if subjects.length === 0 }
                            <div class="flex w-full py-6">
                                <p class="italic text-gray-500">No subject to add</p>
                            </div>
                        { :else }
                            { #each subjects as subject }
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
                            { /each }
                        {/if}
                    </div>

                    <div class="pt-10 w-40">
                        <Button { disabled } on:click={ assignSubjectToTeacher } buttonText="Assign Subjects" />
                    </div>
                </div>
            { /if }

            { #if (slideFormState === panelState.assignClasses) }
                <div class="flex flex-col space-y-3 p-3">
                    <p class="text-gray-800 font-semibold pb-6">Classes</p>

                    <div class="space-y-3">
                        { #if classes.length === 0 }
                            <div class="flex w-full py-6">
                                <p class="italic text-gray-500">No classe to add</p>
                            </div>
                        { :else }
                            { #each classes as grade }
                                <div class="flex space-x-2 items-center w-full">
                                    <button  on:click={ () => selectClass(grade) } class={`flex items-center shrink-0 justify-center  h-[3.2rem] w-[3.2rem] border-2 ${ isClassSelected(grade.id) ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                        <Icons icon="check" className={`${ isClassSelected(grade.id) ? "stroke-green-700" : "stroke-gray-300" }`} />
                                    </button>
                                    <div class="w-full">
                                        <button type="button" class={`flex p-3 border-2 ${ isClassSelected(grade.id) ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                            <span class={`${ isClassSelected(grade.id) ? "text-green-700" : "text-gray-400" }`} >{ grade.class_name }</span>
                                        </button>
                                    </div>
                                </div>
                            { /each }
                        {/if}
                    </div>

                    <div class="pt-10 w-40">
                        <Button { disabled } on:click={ assignClassToTeacher } buttonText="Assign Classes" />
                    </div>
                </div>
            { /if }

            { #if (slideFormState === panelState.assignClassSubjects) }
                <div class="flex flex-col space-y-3 p-3">
                    <p class="text-gray-800 font-semibold pb-6">Class Subjects</p>

                    <div class="space-y-3">
                        { #if teacherSubjects.length === 0 }
                            <div class="flex w-full py-6">
                                <p class="italic text-gray-500">No Subjects</p>
                            </div>
                        { :else }
                            { #each teacherSubjects as subject, subIndex }
                                
                                <p class="font-semibold pt-5">{ subject.subjectName }</p>

                                <div class="ml-4 space-y-3">
                                    { #each teacherClasses as grade, classIndex }
                                        <div class="flex space-x-2 items-center w-full">
                                            <button  on:click={ () => selectClassSubjects(subIndex, grade.class_code) } class={`flex items-center shrink-0 justify-center h-[3.2rem] w-[3.2rem] border-2 ${ isClassSubjectSelected(teacherSubjects[subIndex]?.subjectId, grade.class_code) ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                                <Icons icon="check" className={`${ isClassSubjectSelected(teacherSubjects[subIndex]?.subjectId, grade.class_code) ? "stroke-green-700" : "stroke-gray-300" }`} />
                                            </button>
                                            <div class="w-full">
                                                <button type="button" class={`flex p-3 border-2 ${ isClassSubjectSelected(teacherSubjects[subIndex]?.subjectId, grade.class_code) ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                                    <span class={`${ isClassSubjectSelected(teacherSubjects[subIndex]?.subjectId, grade.class_code) ? "text-green-700" : "text-gray-400" }`} >{ grade.class_name }</span>
                                                </button>
                                            </div>
                                        </div>
                                    {/each}
                                </div>
                                
                            { /each }
                        {/if}
                    </div>

                    <div class="pt-10 w-40">
                        <Button { disabled } on:click={ assignClassSubjectsToTeacher } buttonText="Assign" />
                    </div>
                </div>
            { /if }
        </div>
    </SlidePanel>
</Layout>