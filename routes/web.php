<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', 'UserController@index');
// Route::get('/login', 'UserController@index');
// Route::post('/login', 'UserController@loginPost');
// Route::get('/forgotPass', 'UserController@forgotPass');
// Route::post('/forgotPasswordPost', 'UserController@forgotPasswordPost');
// Route::get('/dashboard', 'UserController@dashboard');
// Route::get('/logout', 'UserController@logout');
// Route::post('/changePasswordPost', 'UserController@changePasswordPost');
// Route::get('/verifyEmail', 'UserController@verifyEmail');
// Route::get('/resetPassword/{token}', 'UserController@resetPassword');
// Route::post('/resetPasswordPost', 'UserController@resetPasswordPost');
Route::get('/logout', 'UserController@logout');

Route::group(['middleware' => 'CheckLogin'], function () {
	Route::get('/', 'UserController@index');
	Route::get('/login', 'UserController@index');
});
	Route::post('/login', 'UserController@loginPost');
	Route::get('/forgotPass', 'UserController@forgotPass');
	Route::post('/forgotPasswordPost', 'UserController@forgotPasswordPost');
	Route::get('/dashboard', 'UserController@dashboard');
	Route::post('/changePasswordPost', 'UserController@changePasswordPost');
	Route::get('/verifyEmail', 'UserController@verifyEmail');
	Route::get('/resetPassword/{token}', 'UserController@resetPassword');
	Route::post('/resetPasswordPost', 'UserController@resetPasswordPost');

//change language
Route::post('/switchLanguage','UserController@switchLanguage');


// Route::post('/editProfile', 'UserController@editProfile');

// Route::get('dashboard', function () {
//     return redirect('home/dashboard');
// });

Route::prefix('employee')->namespace('Employee')->group(function () {	
	Route::get('/profile', 'EmployeeController@profile');
	Route::post('/editProfile', 'EmployeeController@editProfile');
	Route::get('/dashboard', 'EmployeeController@dashboard');
	Route::post('/fetchCollege', 'EmployeeController@fetchCollege');
	Route::post('/editEducationDetails', 'EmployeeController@editEducationDetails');
	Route::post('/editEngagementDetails', 'EmployeeController@editEngagementDetails');

	//change Role
	Route::post('/switchRole','EmployeeController@switchRole');
	
	//Routes For Employee
	Route::group(['middleware'=>'CheckEmployee'],function(){

		//School coordinator my School schoolcoordinator
		Route::get('/mySchool', 'SchoolCoordinatorController@mySchool');
		Route::post('/mySchool', 'SchoolCoordinatorController@mySchoolPost');

		//School coordinator class creation schoolcoordinator
		Route::get('/classCreation', 'ClassCreationController@classCreation');
		Route::post('/classCreation', 'ClassCreationController@classCreationPost');
		Route::post('/getClassStudents', 'ClassCreationController@getClassStudents');
		//School coordinator class creation listing
		Route::get('/classCreations', 'ClassCreationController@classCreations');
		Route::post('/getClassCreations', 'ClassCreationController@getClassCreations');
		Route::post('/deleteClassCreations', 'ClassCreationController@deleteClassCreations');

		//Routes For Village School schoolcoordinator
		Route::get('/villageSchools', 'VillageSchoolController@villageSchools');
		Route::post('/addVillageSchool', 'VillageSchoolController@addVillageSchool');
		Route::post('/getVillageSchool', 'VillageSchoolController@getVillageSchool');
		Route::post('/getVillageSchools', 'VillageSchoolController@getVillageSchools');
		Route::post('/deleteVillageSchool', 'VillageSchoolController@deleteVillageSchool');

		//Route for Main Book schoolcoordinator
		Route::get('/mainBooks', 'MainBookController@mainBooks');
		Route::post('/addMainBook', 'MainBookController@addMainBook');
		Route::post('/getMainBook', 'MainBookController@getMainBook');
		Route::post('/getMainBooks', 'MainBookController@getMainBooks');
		Route::get('/viewMainBook/{id}', 'MainBookController@viewMainBook');
		Route::post('/getMainBookStudents', 'MainBookController@getMainBookStudents');
		Route::post('/deleteMainBook', 'MainBookController@deleteMainBook');

		//Route for Employees schoolcoordinator
		Route::get('/employees', 'TeacherController@employees');
		Route::post('/getEmployees', 'TeacherController@getEmployees');
		Route::post('/getEngageEmployees', 'TeacherController@getEngageEmployees');
		Route::get('/addEmployee', 'TeacherController@addEmployee');
		Route::post('/addEmployee', 'TeacherController@addEmployeePost');
		Route::get('/editEmployee/{id}', 'TeacherController@editEmployee');
		Route::get('/viewEmployee/{id}', 'TeacherController@viewEmployee');
		Route::post('/deleteEmployee', 'TeacherController@deleteEmployee');
		Route::post('/editEmployee', 'TeacherController@editEmployeePost');
		Route::get('/engageEmployee', 'TeacherController@engageEmployee');
		Route::post('/engageEmployee', 'TeacherController@engageEmployeePost');

		//Route for School Sub Admin schoolcoordinator
		Route::get('/subAdmins', 'SubAdminController@subAdmins');
		Route::post('/getSubAdmins', 'SubAdminController@getSubAdmins');
		Route::get('/addSubAdmin', 'SubAdminController@addSubAdmin');
		Route::post('/addSubAdmin', 'SubAdminController@addSubAdminPost');
		Route::get('/editSubAdmin/{id}', 'SubAdminController@editSubAdmin');
		Route::get('/viewSubAdmin/{id}', 'SubAdminController@viewSubAdmin');
		Route::post('/deleteSubAdmin', 'SubAdminController@deleteSubAdmin');
		Route::post('/editSubAdmin', 'SubAdminController@editSubAdminPost');
			
		//Routes for Student Add And Edit schoolcoordinator
		Route::get('/students', 'StudentController@student');
		Route::post('/getStudent', 'StudentController@getStudent');
		Route::get('/addStudent', 'StudentController@addStudent');
		Route::post('/addStudent', 'StudentController@addStudentPost');
		Route::get('/editStudent/{id}', 'StudentController@editStudent');
		Route::post('/editStudent', 'StudentController@editStudentPost');
		Route::post('/deleteStudent', 'StudentController@deleteStudent');
		Route::get('/viewStudent/{id}', 'StudentController@viewStudent');

		//Routes for  enroll student schoolcoordinator
		Route::get('/enrollStudents', 'EnrollStudentController@enrollStudents');
		Route::post('/getEnrollStudent', 'EnrollStudentController@getEnrollStudent');
		Route::post('/enrollStudentPost', 'EnrollStudentController@enrollStudentPost');
		Route::get('/viewEducationPlan/{id}', 'EnrollStudentController@viewEducationPlan');
	});	
});

Route::prefix('admin')->namespace('Admin')->group(function () {
	
	Route::get('/fetchContent/{slug}', 'AdminController@fetchContent');
	Route::get('/profile', 'AdminController@profile');
	Route::post('/editProfile', 'AdminController@editProfile');
	Route::get('/dashboard', 'AdminController@dashboard');
	
	Route::group(['middleware'=>'CheckHertronicAndMinistryAdmin'],function(){
		
		//Routes for Student
		Route::get('/students', 'StudentController@student');
		Route::post('/getStudent', 'StudentController@getStudent');
		Route::get('/editStudent/{id}', 'StudentController@editStudent');
		Route::post('/editStudent', 'StudentController@editStudentPost');
		Route::get('/viewStudent/{id}', 'StudentController@viewStudent');

		//Route for Employees
		Route::get('/employees', 'TeacherController@employees');
		Route::post('/getEmployees', 'TeacherController@getEmployees');
		Route::get('/editEmployee/{id}', 'TeacherController@editEmployee');
		Route::get('/viewEmployee/{id}', 'TeacherController@viewEmployee');
		Route::post('/editEmployee', 'TeacherController@editEmployeePost');
	
	});
	
	//Routes For Hertronic Admin
	Route::group(['middleware'=>'HertronicAdmin'],function(){

		//Route for Login as
		Route::get('/loginAs', 'LoginAsController@loginAs');
		Route::post('/getLoginAs', 'LoginAsController@getLoginAs');
		Route::post('/authLoginAs', 'LoginAsController@authLoginAs');
		
		//Route for Ministries
		Route::get('/ministries', 'MinistryController@ministries');
		Route::post('/getMinistries', 'MinistryController@getMinistries');
		Route::get('/addMinistry', 'MinistryController@addMinistry');
		Route::post('/addMinistry', 'MinistryController@addMinistryPost');
		Route::get('/editMinistry/{id}', 'MinistryController@editMinistry');
		Route::get('/viewMinistry/{id}', 'MinistryController@viewMinistry');
		Route::post('/deleteMinistry', 'MinistryController@deleteMinistry');
		Route::post('/editMinistry', 'MinistryController@editMinistryPost');

		//Route for Countries
		Route::get('/countries', 'CountryController@countries');
		Route::post('/addCountry', 'CountryController@addCountry');
		Route::post('/getCountry', 'CountryController@getCountry');
		Route::post('/getCountries', 'CountryController@getCountries');
		Route::post('/deleteCountry', 'CountryController@deleteCountry');

		//Route for States
		Route::get('/states', 'StateController@states');
		Route::post('/addState', 'StateController@addState');
		Route::post('/getState', 'StateController@getState');
		Route::post('/getStates', 'StateController@getStates');
		Route::post('/deleteState', 'StateController@deleteState');

		//Route for Cantons
		Route::get('/cantons', 'CantonController@cantons');
		Route::post('/addCanton', 'CantonController@addCanton');
		Route::post('/getCanton', 'CantonController@getCanton');
		Route::post('/getCantons', 'CantonController@getCantons');
		Route::post('/deleteCanton', 'CantonController@deleteCanton');
		Route::post('/getStatesByCountry', 'CantonController@getStatesByCountry');

		//Route for Academic Degrees
		Route::get('/academicDegrees', 'AcademicDegreeController@academicDegrees');
		Route::post('/addAcademicDegree', 'AcademicDegreeController@addAcademicDegree');
		Route::post('/getAcademicDegree', 'AcademicDegreeController@getAcademicDegree');
		Route::post('/getAcademicDegrees', 'AcademicDegreeController@getAcademicDegrees');
		Route::post('/deleteAcademicDegree', 'AcademicDegreeController@deleteAcademicDegree');

		//Route for Job & Works
		Route::get('/jobAndWorks', 'JobAndWorkController@jobAndWorks');
		Route::post('/addJobAndWork', 'JobAndWorkController@addJobAndWork');
		Route::post('/getJobAndWork', 'JobAndWorkController@getJobAndWork');
		Route::post('/getJobAndWorks', 'JobAndWorkController@getJobAndWorks');
		Route::post('/deleteJobAndWork', 'JobAndWorkController@deleteJobAndWork');

		//Route for Ownership Types
		Route::get('/ownershipTypes', 'OwnershipTypeController@ownershipTypes');
		Route::post('/addOwnershipType', 'OwnershipTypeController@addOwnershipType');
		Route::post('/getOwnershipType', 'OwnershipTypeController@getOwnershipType');
		Route::post('/getOwnershipTypes', 'OwnershipTypeController@getOwnershipTypes');
		Route::post('/deleteOwnershipType', 'OwnershipTypeController@deleteOwnershipType');

		//Route for Universities
		Route::get('/universities', 'UniversityController@universities');
		Route::post('/addUniversity', 'UniversityController@addUniversity');
		Route::post('/getUniversity', 'UniversityController@getUniversity');
		Route::post('/getUniversities', 'UniversityController@getUniversities');
		Route::post('/deleteUniversity', 'UniversityController@deleteUniversity');

		//Route for Colleges
		Route::get('/colleges', 'CollegeController@colleges');
		Route::post('/addCollege', 'CollegeController@addCollege');
		Route::post('/getCollege', 'CollegeController@getCollege');
		Route::post('/getColleges', 'CollegeController@getColleges');
		Route::post('/deleteCollege', 'CollegeController@deleteCollege');

		//Route for National Education Plans
		Route::get('/nationalEducationPlans', 'NationalEducationPlanController@educationPlans');
		Route::post('/addNationalEducationPlan', 'NationalEducationPlanController@addEducationPlan');
		Route::post('/getNationalEducationPlan', 'NationalEducationPlanController@getEducationPlan');
		Route::post('/getNationalEducationPlans', 'NationalEducationPlanController@getEducationPlans');
		Route::post('/deleteNationalEducationPlan', 'NationalEducationPlanController@deleteEducationPlan');

		//Route for Education Profiles
		Route::get('/educationProfiles', 'EducationProfileController@educationProfiles');
		Route::post('/addEducationProfile', 'EducationProfileController@addEducationProfile');
		Route::post('/getEducationProfile', 'EducationProfileController@getEducationProfile');
		Route::post('/getEducationProfiles', 'EducationProfileController@getEducationProfiles');
		Route::post('/deleteEducationProfile', 'EducationProfileController@deleteEducationProfile');

		//Route for Qualification Degrees
		Route::get('/qualificationDegrees', 'QualificationDegreeController@qualificationDegrees');
		Route::post('/addQualificationDegree', 'QualificationDegreeController@addQualificationDegree');
		Route::post('/getQualificationDegree', 'QualificationDegreeController@getQualificationDegree');
		Route::post('/getQualificationDegrees', 'QualificationDegreeController@getQualificationDegrees');
		Route::post('/deleteQualificationDegree', 'QualificationDegreeController@deleteQualificationDegree');

		//Route for Municipalities
		Route::get('/municipalities', 'MunicipalityController@municipalities');
		Route::post('/addMunicipality', 'MunicipalityController@addMunicipality');
		Route::post('/getMunicipality', 'MunicipalityController@getMunicipality');
		Route::post('/getMunicipalities', 'MunicipalityController@getMunicipalities');
		Route::post('/deleteMunicipality', 'MunicipalityController@deleteMunicipality');

		//Route for Postal Codes
		Route::get('/postalCodes', 'PostalCodeController@postalCodes');
		Route::post('/addPostalCode', 'PostalCodeController@addPostalCode');
		Route::post('/getPostalCode', 'PostalCodeController@getPostalCode');
		Route::post('/getPostalCodes', 'PostalCodeController@getPostalCodes');
		Route::post('/deletePostalCode', 'PostalCodeController@deletePostalCode');

		//Route for Language
		Route::get('/languages', 'LanguageController@languages');
		Route::post('/addLanguage', 'LanguageController@addLanguage');
		Route::post('/getLanguage', 'LanguageController@getLanguage');
		Route::post('/getLanguages', 'LanguageController@getLanguages');
		Route::post('/deleteLanguage', 'LanguageController@deleteLanguage');

		//Route for Translations
		Route::get('/translations', 'TranslationController@translations');
		Route::post('/addTranslation', 'TranslationController@addTranslation');
		Route::post('/getTranslation', 'TranslationController@getTranslation');
		Route::post('/getTranslations', 'TranslationController@getTranslations');
		Route::post('/deleteTranslation', 'TranslationController@deleteTranslation');

		//Routes for Village School
		Route::get('/villageSchools', 'VillageSchoolController@villageSchools');
		Route::post('/getVillageSchools', 'VillageSchoolController@getVillageSchools');

		//Routes for Employee
		/*Route::get('/employees', 'TeacherController@Employees');
		Route::post('/getEmployees', 'TeacherController@getEmployees');*/

	});

	//common routes
	//Route for Grades
	Route::get('/grades', 'GradeController@grades');
	Route::post('/addGrade', 'GradeController@addGrade');
	Route::post('/getGrade', 'GradeController@getGrade');
	Route::post('/getGrades', 'GradeController@getGrades');
	Route::post('/deleteGrade', 'GradeController@deleteGrade');

	//Route for Classes
	Route::get('/classes', 'ClassController@classes');
	// Route::post('/addClass', 'ClassController@addClass');
	Route::post('/getClass', 'ClassController@getClass');
	Route::post('/getClasses', 'ClassController@getClasses');
	Route::post('/deleteClass', 'ClassController@deleteClass');

	//Route for Courses
	Route::get('/courses', 'CourseController@courses');
	Route::post('/addCourse', 'CourseController@addCourse');
	Route::post('/getCourse', 'CourseController@getCourse');
	Route::post('/getCourses', 'CourseController@getCourses');
	Route::post('/deleteCourse', 'CourseController@deleteCourse');

	//Route for Education Plans
	Route::get('/educationPlans', 'EducationPlanController@educationPlans');
	Route::get('/editEducationPlan/{id}', 'EducationPlanController@editEducationPlan');
	Route::get('/viewEducationPlan/{id}', 'EducationPlanController@viewEducationPlan');
	Route::post('/editEducationPlan', 'EducationPlanController@editEducationPlanPost');
	Route::post('/getEducationPlans', 'EducationPlanController@getEducationPlans');
	Route::post('/deleteEducationPlan', 'EducationPlanController@deleteEducationPlan');

	//Route for Schools
	Route::get('/schools', 'SchoolController@schools');
	Route::get('/editSchool/{id}', 'SchoolController@editSchool');
	Route::get('/viewSchool/{id}', 'SchoolController@viewSchool');
	Route::post('/editSchool', 'SchoolController@editSchoolPost');
	Route::post('/getSchools', 'SchoolController@getSchools');
	Route::post('/deleteSchool', 'SchoolController@deleteSchool');
	Route::post('/fetchEducationPlan', 'SchoolController@fetchEducationPlan');

	// Routes for Ministry Admin
	Route::group(['middleware'=>'MinistryAdmin'],function(){

		//Route for Sub Admins
		Route::get('/subAdmins', 'SubAdminController@subAdmins');
		Route::post('/getSubAdmins', 'SubAdminController@getSubAdmins');
		Route::get('/addSubAdmin', 'SubAdminController@addSubAdmin');
		Route::post('/addSubAdmin', 'SubAdminController@addSubAdminPost');
		Route::get('/editSubAdmin/{id}', 'SubAdminController@editSubAdmin');
		Route::get('/viewSubAdmin/{id}', 'SubAdminController@viewSubAdmin');
		Route::post('/deleteSubAdmin', 'SubAdminController@deleteSubAdmin');
		Route::post('/editSubAdmin', 'SubAdminController@editSubAdminPost');

		//Route for Religions
		Route::get('/religions', 'ReligionController@religions');
		Route::post('/addReligion', 'ReligionController@addReligion');
		Route::post('/getReligion', 'ReligionController@getReligion');
		Route::post('/getReligions', 'ReligionController@getReligions');
		Route::post('/deleteReligion', 'ReligionController@deleteReligion');

		//Route for Citizenships
		Route::get('/citizenships', 'CitizenshipController@citizenships');
		Route::post('/addCitizenship', 'CitizenshipController@addCitizenship');
		Route::post('/getCitizenship', 'CitizenshipController@getCitizenship');
		Route::post('/getCitizenships', 'CitizenshipController@getCitizenships');
		Route::post('/deleteCitizenship', 'CitizenshipController@deleteCitizenship');

		//Route for Vocations
		Route::get('/vocations', 'VocationController@vocations');
		Route::post('/addVocation', 'VocationController@addVocation');
		Route::post('/getVocation', 'VocationController@getVocation');
		Route::post('/getVocations', 'VocationController@getVocations');
		Route::post('/deleteVocation', 'VocationController@deleteVocation');

		//Route for Nationalities
		Route::get('/nationalities', 'NationalityController@nationalities');
		Route::post('/addNationality', 'NationalityController@addNationality');
		Route::post('/getNationality', 'NationalityController@getNationality');
		Route::post('/getNationalities', 'NationalityController@getNationalities');
		Route::post('/deleteNationality', 'NationalityController@deleteNationality');

		//Route for School Year
		Route::get('/schoolYear', 'SchoolYearController@index');
		Route::post('/addSchoolYear', 'SchoolYearController@addSchoolYear');
		Route::post('/getSchoolYear', 'SchoolYearController@getSchoolYear');
		Route::post('/getSchoolYears', 'SchoolYearController@getSchoolYears');
		Route::post('/deleteSchoolYear', 'SchoolYearController@deleteSchoolYear');

		//Route for Education Period
		Route::get('/educationPeriod', 'EducationPeriodController@index');
		Route::post('/addEducationPeriod', 'EducationPeriodController@addEducationPeriod');
		Route::post('/getEducationPeriod', 'EducationPeriodController@getEducationPeriod');
		Route::post('/getEducationPeriods', 'EducationPeriodController@getEducationPeriods');
		Route::post('/deleteEducationPeriod', 'EducationPeriodController@deleteEducationPeriod');

		//Route for Student Behaviour
		Route::get('/studentBehaviour', 'StudentBehaviourController@index');
		Route::post('/addStudentBehaviour', 'StudentBehaviourController@addStudentBehaviour');
		Route::post('/getStudentBehaviour', 'StudentBehaviourController@getStudentBehaviour');
		Route::post('/getStudentBehaviours', 'StudentBehaviourController@getStudentBehaviours');
		Route::post('/deleteStudentBehaviour', 'StudentBehaviourController@deleteStudentBehaviour');

		//Route for Extra Curricural Activity Type
		Route::get('/extracurricuralActivityType', 'ExtracurricuralActivityTypeController@index');
		Route::post('/addExtracurricuralActivityType', 'ExtracurricuralActivityTypeController@addExtracurricuralActivityType');
		Route::post('/getExtracurricuralActivityType', 'ExtracurricuralActivityTypeController@getExtracurricuralActivityType');
		Route::post('/getExtracurricuralActivityTypes', 'ExtracurricuralActivityTypeController@getExtracurricuralActivityTypes');
		Route::post('/deleteExtracurricuralActivityType', 'ExtracurricuralActivityTypeController@deleteExtracurricuralActivityType');

		//Route for Discipline Measure Type
		Route::get('/disciplineMeasureType', 'StudentDisciplineMeasureTypeController@index');
		Route::post('/addDisciplineMeasureType', 'StudentDisciplineMeasureTypeController@addDisciplineMeasureType');
		Route::post('/getDisciplineMeasureType', 'StudentDisciplineMeasureTypeController@getDisciplineMeasureType');
		Route::post('/getDisciplineMeasureTypes', 'StudentDisciplineMeasureTypeController@getDisciplineMeasureTypes');
		Route::post('/deleteDisciplineMeasureType', 'StudentDisciplineMeasureTypeController@deleteDisciplineMeasureType');

		//Route for Optional Courses Group Type
		Route::get('/optionalCoursesGroup', 'OptionalCoursesGroupController@index');
		Route::post('/addOptionalCoursesGroup', 'OptionalCoursesGroupController@addOptionalCoursesGroup');
		Route::post('/getOptionalCoursesGroup', 'OptionalCoursesGroupController@getOptionalCoursesGroup');
		Route::post('/getOptionalCoursesGroups', 'OptionalCoursesGroupController@getOptionalCoursesGroups');
		Route::post('/deleteOptionalCoursesGroup', 'OptionalCoursesGroupController@deleteOptionalCoursesGroup');

		//Route for Facultative Courses Groups 
	  	Route::get('/facultativeCoursesGroup', 'FacultativeCoursesGroupController@index');
		Route::post('/addFacultativeCoursesGroup', 'FacultativeCoursesGroupController@addFacultativeCoursesGroup');
		Route::post('/getFacultativeCoursesGroup', 'FacultativeCoursesGroupController@getFacultativeCoursesGroup');
		Route::post('/getFacultativeCoursesGroups', 'FacultativeCoursesGroupController@getFacultativeCoursesGroups');
		Route::post('/deleteFacultativeCoursesGroup', 'FacultativeCoursesGroupController@deleteFacultativeCoursesGroup');

		//Route for Facultative Courses Groups 
	  	Route::get('/generalPurposeGroup', 'GeneralPurposeGroupController@index');
		Route::post('/addGeneralPurposeGroup', 'GeneralPurposeGroupController@addGeneralPurposeGroup');
		Route::post('/getGeneralPurposeGroup', 'GeneralPurposeGroupController@getGeneralPurposeGroup');
		Route::post('/getGeneralPurposeGroups', 'GeneralPurposeGroupController@getGeneralPurposeGroups');
		Route::post('/deleteGeneralPurposeGroup', 'GeneralPurposeGroupController@deleteGeneralPurposeGroup');
		
		//Route for Foreign Language Group 
	  	Route::get('/foreignLanguageGroup', 'ForeignLanguageGroupController@index');
		Route::post('/addForeignLanguageGroup', 'ForeignLanguageGroupController@addForeignLanguageGroup');
		Route::post('/getForeignLanguageGroup', 'ForeignLanguageGroupController@getForeignLanguageGroup');
		Route::post('/getForeignLanguageGroups', 'ForeignLanguageGroupController@getForeignLanguageGroups');
		Route::post('/deleteForeignLanguageGroup', 'ForeignLanguageGroupController@deleteForeignLanguageGroup');

		//Route for Education Program 
	  	Route::get('/educationProgram', 'EducationProgramController@index');
		Route::get('/addEducationProgram', 'EducationProgramController@addEducationProgram');
		Route::post('/addEducationProgram', 'EducationProgramController@addEducationProgramPost');
		Route::get('/editEducationProgram/{id}', 'EducationProgramController@editEducationProgram');
		Route::post('/getEducationProgram', 'EducationProgramController@getEducationProgram');
		Route::post('/getEducationPrograms', 'EducationProgramController@getEducationPrograms');
		Route::post('/deleteEducationProgram', 'EducationProgramController@deleteEducationProgram');

		//Route for Education Plans
		Route::get('/addEducationPlan', 'EducationPlanController@addEducationPlan');
		Route::post('/addEducationPlan', 'EducationPlanController@addEducationPlanPost');

		//Route for  Schools
		Route::get('/addSchool', 'SchoolController@addSchool');
		Route::post('/addSchool', 'SchoolController@addSchoolPost');

	});
});

Route::prefix('student')->namespace('Student')->group(function () {	
	Route::get('/profile', 'StudentController@profile');
	Route::post('/editProfile', 'StudentController@editProfile');
	Route::get('/dashboard', 'StudentController@dashboard');
});