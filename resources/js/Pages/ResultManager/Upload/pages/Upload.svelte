<script>
    import TopHeader from "../../../layouts/top_header.svelte";
    import Layout from "../../../layouts/Layout.svelte";
    import AppContainer from "../../../layouts/app_container.svelte";
    import Button from "../../../components/button.svelte";
    import SlidePanel from "../../../components/slide_panel.svelte";
    import Table from "../../../components/table.svelte";
    import Input from "../../../components/input.svelte";
    import Icons from "../../../components/icons.svelte";
    import Select from "../../../components/select.svelte";

    let slidePanelStates = {

            "import_results" : "Import Results"
    }


    let assessmentTypes = [
        { placeholder: 'CAT 1', value: 'CAT 1'}
    ];

    let subjects = [
        { placeholder: 'English', value: 'English'}
    ];

    let classes = [
        { placeholder: 'Primary 1', value: 'Primary 1'}
    ];

    let terms = [
        { placeholder: 'First Term', value: 'First Term'},
        { placeholder: 'Second Term', value: 'Second Term'},
        { placeholder: 'Third Term', value: 'Third Term'},
    ];

    let academicSession = [
        { placeholder: '2023/2024', value: '2023/2024'}
    ];

    let shouldShowImportSheet = false
    let showResults = false;


    let selectedSubject;

    const showImportSheet = () => shouldShowImportSheet = true

    let studentsResults = [
        { id: 1, studentName: 'Michah Richards', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 2, studentName: 'Lesli James', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 3, studentName: 'Nina Brown', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 4, studentName: 'Peter Michael', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 5, studentName: 'Jonh Jiin', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 6, studentName: 'Stewart Lore', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 7, studentName: 'Janet Lee', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 8, studentName: 'Sonny House', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
    ]


    let resultsHeadings = ['Student Name', 'Score'];

</script>

<Layout>
    <SlidePanel title="Import Results" showSheet={ false } on:onpanelstatus={ () => {} } >
        <TopHeader title="Upload Results For" className="text-base" >
            <div class="flex items-center space-x-2">
                <Button buttonText="Import Results" className="text-sm bg-green-500 hover:bg-green-600 text-white focus:bg-green-500 focus:ring-green-200" />
            </div>
        </TopHeader>

       
            

            <div class="fixed h-[calc(100vh-8rem)] bottom-0 flex flex-col items-center w-96 border-r bg-white">
                <p class="flex fixed items-center font-extrabold text-lg text-gray-600 px-8 h-16 w-96"></p>
                <div class="fixed space-y-3 text-xs pb-10 w-96 h-[calc(100vh-12rem)] bottom-0 overflow-y-auto">
                    <div class="flex items-center w-full px-6 text-sm text-gray-600">
                        <Select on:deselected={ () => {  } } value={ ''  } isSelected={ false } on:selected={ (e) => {} } options={ [] } placeholder={ "Select a Level" } className="text-sm py-2.5" label="Select Class" labelStyle="font-bold text-gray-800 text-base"/>
                    </div>
                    <div class="p-6 w-full">
                       <div class="w-full mt-4">
                            <h3 class="text-gray-800 text-base font-bold pb-4">Subjects</h3>
                            <div class="space-y-2">
                                <!-- { #if currentClassSubjects.length == 0 } -->
                                    <p class="text-gray-500 italic">No Course Available</p>
                                <!-- { :else } -->
                                    <!-- <button  on:click={ selectAllSubjects } class={`flex items-center shrink-0 justify-center h-12 w-12 border-2 ${ selectAll ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                        <Icons icon="check" className={`${ selectAll ? "stroke-green-700" : "stroke-gray-300" }`} />
                                    </button> -->
                                  <!-- { #each Object.values(currentClassSubjects) as subject, index(`${selectedClassId}_${subject.subjectId}`) }
                                        <div class="flex space-x-2 items-center w-full">
                                            <button  on:click={ () => selectSubject(subject) } class={`flex items-center shrink-0 justify-center h-12 w-12 border-2 ${ subject.isSelected ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                                <Icons icon="check" className={`${ subject.isSelected  ? "stroke-green-700" : "stroke-gray-300" }`} />
                                            </button>
                                            <div class="w-full">
                                                <button type="button" class={ `flex p-3 border-2 ${ subject.isSelected  ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                                    <span class={ `text-left text-sm ${ subject.isSelected  ? "text-green-700" : "text-gray-400" }` } >{ subject.subjectName }</span>
                                                </button>
                                            </div>
                                        </div>
                                  { /each }
                                { /if } -->
                            </div>
                       </div>
                    </div>
                </div>
            </div>
    
            <div class="fixed h-[calc(100vh-8rem)] bottom-0 right-0 flex flex-col w-[calc(100vw-39rem)] bg-white">
                <div class="fixed flex items-center justify-between border-b space-x-8 h-16 w-[calc(100vw-39rem)] px-6 bg-white">
                    <span class="font-extrabold text-2xl min-w-max max-w-min text-gray-800">Result Sheet</span>
                    <div class="w-full">
                        <Input className="w-full" id="title" placeholder="Search for Student" on:input={ () => {}  } />
                    </div>
                    <Button  buttonText="Save Result" className="min-w-max max-w-min text-sm" />
                </div>
                
                <div class="fixed h-[calc(100vh-12rem)] bottom-0 right-0 flex flex-col w-[calc(100vw-39rem)] bg-white space-y-4 pt-8 pb-16 px-7 overflow-y-auto">
                    <div class="bg-white rounded-lg">
                        <div>
                            <div class="flex justify-between space-x-10 border-b pb-6 pr-8">
                                <div class="w-full font-extrabold text-gray-800">Student</div>
                                <div class="w-20 font-extrabold text-gray-800">Score</div>
                            </div>
                            <div class="flex flex-col">
                                { #each studentsResults as result, index(result.id) }
                                    <div class="flex items-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 justify-between pb-6">
                                        
                                        <div class="text-gray-700 whitespace-nowrap dark:text-white w-full">{ result.studentName }</div>
                                        <div class="flex flex-col items-center space-y-1 text-gray-800 whitespace-nowrap dark:text-white w-20 mt-6 pr-12">
                                            <Input className="w-20" id="title" type="number" value={ result.score } on:input={ () => {}  } />
                                            <small class="text-[0.65em] text-gray-500">Max score: 20</small>
                                        </div>
                                    </div>
                                { /each }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            
       
      
    </SlidePanel>
</Layout>