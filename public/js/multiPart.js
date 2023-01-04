// (function(){
// document.querySelector('.slider').innerHTML =  document.querySelectorAll('.slider fieldset')[0].outerHTML.repeat(10)
// })();

const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const questions = document.querySelectorAll('.slider fieldset');
const slider = document.querySelector('.slider');
const progressBar = document.querySelector('.progress-bar-indicator');

let currQuestion = 0;
let questionNr;

const schema = {
    fields: [
        {
            title:
                'Există o relaţie de comunicare şi colaborare între dvs. si şefii ierarhici?',
            fieldOrder: 1,
            options: [
                {
                    value: 2,
                    label: 'Da'
                },
                {
                    value: 3,
                    label: 'Partial'
                },
                {
                    value: 5,
                    label: 'NU'
                }
            ]
        },
        {
            title:
                'Ca şi angajat, cunoaşteţi care sunt rezultatele aşteptate de şefii dvs. în privinţa activităţii pe care o desfăşuraţi?',
            fieldOrder: 2,
            options: [
                {
                    value: 2,
                    label: 'Da'
                },
                {
                    value: 3,
                    label: 'Partial'
                },
                {
                    value: 5,
                    label: 'NU'
                }
            ]
        },
        {
            title:
                'Vă simţiţi în siguranţă în ceea ce priveşte dotarea materială cu echipamente, unelte, aparatură, necesare desfăşurării activităţii dvs.? Sunteţi mulţumit?',
            fieldOrder: 3,
            options: [
                {
                    value: 2,
                    label: 'Da'
                },
                {
                    value: 3,
                    label: 'Partial'
                },
                {
                    value: 5,
                    label: 'NU'
                }
            ]
        },
        {
            title:
                ' Consideraţi că la nivelul spitalului există o politică de promovare a angajaţilor?',
            fieldOrder: 4,
            options: [
                {
                    value: 2,
                    label: 'Da'
                },
                {
                    value: 3,
                    label: 'Partial'
                },
                {
                    value: 5,
                    label: 'NU'
                }
            ]
        },
        {
            title:
                'Consideraţi că sunteţi suficient de bine informat cu privire la riscurile locului de munca?',
            fieldOrder: 5,
            options: [
                {
                    value: 2,
                    label: 'Da'
                },
                {
                    value: 3,
                    label: 'Partial'
                },
                {
                    value: 5,
                    label: 'NU'
                }
            ]
        }
    ]
};

class SurveyBuilder {
    fields;
    fieldsLocationDOM;
    nrQuestions;
    currQuestion = 0;
    currSelect;
    outputSchema = [];
    createdFieldsDOM = [];
    allowNext = false;
    sendSurveyCallback;

    // canSkip;

    constructor(schema, fieldsLocationDOM) {
        console.log(schema);
        //create copy of the fields
        this.fields = schema.fields;
        this.fieldsLocationDOM = fieldsLocationDOM;
        this.createAllFields();
        this.goToQuestion(0);
        this.nrQuestions = document.querySelectorAll('.slider fieldset').length;
        // this.nrQuestions = this.fields.length
        this.updateProgressBar();

        this.sendBtnDOM = document.querySelector('.form-buttons .send-btn');
        this.formBtns = document.querySelector('.form-buttons');

        this.bindedAddEvents = (e) => {
            if (e.target.className.includes('next-btn')) this.nextQuestion(e);
            if (e.target.className.includes('prev-btn')) this.prevQuestion(e);
            if (e.target.className.includes('send-btn')) this.sendSurvey(e);
        };

        this.formBtns.addEventListener('click', this.bindedAddEvents);

        console.log(this.fields);
    }

    createAllFields() {
        // console.log(schema.fields)
        this.fields.forEach((field, index) => {
            //Add unique id to be synced with the schema
            const id = this._createInputId(10);
            //Add field as select dom element
            const createdField = this.createField(field, index, id);

            this.createdFieldsDOM.push(createdField);

            //Add props in outputSchema
            this.outputSchema.push({
                id: id,
                remark: '',
                title: field.title,
                options: field.options,
                notApplicable: false
            });

            console.log(createdField);

            //Add events to each fields that updates the schema
            createdField
                .querySelector('select')
                .addEventListener('change', this.updateSchema.bind(this));

            //Skip current question
            createdField
                .querySelector('input[type="checkbox"]')
                .addEventListener('change', this.skipQuestion.bind(this));
            //Add remarks
            createdField
                .querySelector('textarea')
                .addEventListener('change', this.updateRemark.bind(this));
        });
    }

    updateRemark(e) {
        const remark = e.target.value;
        const questionId = e.target.dataset.id;
        const outputField = this.outputSchema.find(
            (field) => field.id == questionId
        );

        outputField.remark = remark;
    }

    skipQuestion(e) {
        console.log(e.target.dataset.id);
        const notApplicable = e.target.checked;
        const questionId = e.target.dataset.id;
        const outputField = this.outputSchema.find(
            (field) => field.id == questionId
        );

        outputField.notApplicable = notApplicable;

        // this.canSkip = notApplicable;
    }

    updateSchema(e) {
        const questionId = e.target.dataset.id;
        const outputField = this.outputSchema.find(
            (field) => field.id == questionId
        );
        const selectedValue = e.target.value;

        if (!outputField) {
            this.allowNext = false;
            throw new Error('field not found');
        }

        const valueAllowed = outputField.options.find(
            (el) => el.value == selectedValue
        );

        if (!valueAllowed) {
            this.allowNext = false;
            throw new Error('value not allowed');
        }

        outputField.value = selectedValue;

        this.allowNext = true;

        // console.log(this.outputSchema)
    }

    createField(field, questionNr, id) {
        const { title, options } = field;

        let html = `<fieldset data-id='${id}'>
								<div class="fs-title">Intrebarea ${questionNr + 1}</div>
								<div class="fs-subtitle">
									${title}
								</div>

								<div class="input-slider">
									<div class="fs-input">

                                        <div class="answer-options">
                                            <label class="answer-label" for="answer-${id}">Raspuns</label>
                                            <select name="" id="answer-${id}" data-id='${id}'>
                                                <option disabled hidden selected>

                                                </option>
                                                ${options.map((opt, index) => {
                                                    return `<option value="${opt.value}">${opt.label}</option>`;
                                                })}
                                            </select>
                                        </div>

                                        <div class="remarks">
                                            <label for="remarks-${id}">Observatii</label>
                                            <textarea data-id="${id}" id="remarks-${id}" placeholder="Observatii"> </textarea>
                                        </div>

                                        <div class="unapplicable">
                                            <label for="unapplicable-${id}">Neaplicabil societatii</label>
                                            <input type="checkbox" id="unapplicable-${id}" name="unapplicable-${id}" data-id='${id}'>

                                        </div>

										<div class="error">
											Raspuns obligatoriu
										</div>
									</div>

								</div>
						</fieldset>`;

        this.fieldsLocationDOM.insertAdjacentHTML('beforeend', html);

        // return created dom element
        return document.querySelector(`fieldset[data-id="${id}"]`);
    }

    goToQuestion(questionNr) {
        Array.from(document.querySelectorAll('.slider fieldset')).forEach(
            (question, i) => {
                const margin = 0;
                const scale = questionNr == i ? 'scale(1)' : 'scale(0.5)';
                const opacity = questionNr == i ? '1' : '0.2';

                question.style.transform = `translateX(${
                    100 * (i - questionNr) + margin
                }%) ${scale}`;
                question.style.opacity = opacity;
            }
        );
    }

    addSendSurveyCallback(callback) {
        this.sendSurveyCallback = callback;
    }

    sendSurvey(e) {
        const currSelect = this.createdFieldsDOM[
            this.currQuestion
        ].querySelector('select');

        const fieldId = currSelect.dataset.id;
        const currFieldData = this.outputSchema.find(
            (field) => field.id == fieldId
        );

        // If question is skippable stop checking if it has an answer
        if (!currFieldData.notApplicable) {
            if (!currSelect) return;
            const value = currSelect.value;
            if (!value) {
                throw new Error('No answer selected');
                return;
            }
        }

        this.sendSurveyCallback(JSON.stringify(this.outputSchema));
    }

    nextQuestion(e) {
        const nextBtn = e.target;

        const currSelect = this.createdFieldsDOM[
            this.currQuestion
        ].querySelector('select');

        const fieldId = currSelect.dataset.id;
        const currFieldData = this.outputSchema.find(
            (field) => field.id == fieldId
        );

        // If question is skippable stop checking if it has an answer
        if (!currFieldData.notApplicable) {
            //Check if next allowed
            if (!this.allowNext) {
                throw new Error('Not allowed');
                return;
            }

            //Wait until option is selected
            if (!currSelect.value) return;
        }

        //Stop moving to the next question when we're at the last one
        if (this.currQuestion >= this.nrQuestions - 1) return;

        //Show SEND button and hide NEXT for the last question
        if (this.currQuestion >= this.nrQuestions - 2) {
            nextBtn.classList.add('hide');
            this.sendBtnDOM.classList.remove('hide');
        }

        //prevent next question to be skipped
        // this.canSkip = false;

        //keep track of current question
        this.currQuestion++;

        //move UI to next question
        this.goToQuestion(this.currQuestion);
        this.updateProgressBar();
    }

    prevQuestion() {
        if (this.currQuestion === 0) return;
        this.currQuestion--;
        //move UI to prev question
        this.goToQuestion(this.currQuestion);
        this.updateProgressBar();

        nextBtn.classList.remove('hide');
        this.sendBtnDOM.classList.add('hide');
    }

    updateProgressBar() {
        progressBar.style.width =
            ((this.currQuestion + 1) / this.nrQuestions) * 100 + '%';
    }

    _createInputId(randStringLength) {
        if (!randStringLength || randStringLength < 1) return;

        const alphabet = [...Array(26).keys()].map((i) =>
            String.fromCharCode(i + 97)
        );
        const nrs = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        const hex = [...alphabet, ...nrs];
        const random = function () {
            return Math.floor(Math.random() * hex.length);
        };
        return [...Array(randStringLength)].map(() => hex[random()]).join('');
    }

    reset() {
        this.createdFieldsDOM.forEach((domEl) => domEl.remove());
        this.formBtns.removeEventListener('click', this.bindedAddEvents);
        nextBtn.classList.remove('hide');
        this.sendBtnDOM.classList.add('hide');
    }
}

//slider navigation
// document.querySelector('.form-buttons').addEventListener('click',(e)=>{
// 	if(e.target.className.includes('next-btn')) nextQuestion()
// 	if(e.target.className.includes('prev-btn')) prevQuestion()
// })

// const goToQuestion = function(questionNr){
// 	Array.from(document.querySelectorAll('.slider fieldset')).forEach((question, i) => {
// 		// console.log(`translateX(${100 * (i - questionNr)})`)

// 		// console.log(progressBar.style.width = '30%')

// 		const margin = 0
// 		const scale = questionNr == i ? 'scale(1)' : 'scale(0.5)'

// 		question.style.transform = `translateX(${100 * (i - questionNr) + margin }%) ${scale}`

// 		// progressBar.style.width = `${currQuestion / questionNr * 100}%`
// 	});
// }

// function nextQuestion() {
// 	console.log({
// 		currQuestion,
// 		questionNr
// 	})
// 	if(currQuestion >= questionNr -1) return
// 	currQuestion++
// 	goToQuestion(currQuestion)
// 	updateProgressBar()
// }

// function prevQuestion(){
// 	if(currQuestion === 0) return
// 	currQuestion--
// 	goToQuestion(currQuestion)
// 	updateProgressBar()
// }

// goToQuestion(currQuestion)
// updateProgressBar(1)

// function createAllFields(){
// 	console.log(schema.fields)
// 	schema.fields.forEach((el,index)=>{
// 		// console.log(el)
// 	})
// }

// function createField(){

// <fieldset>

// 	<div class="fs-title">Intrebarea 4</div>
// 	<div class="fs-subtitle">
// 		What postgraduate qualifications do you hold?
// 	</div>

// 	<div class="input-slider">
// 		<div class="fs-input">
// 			<select name="" id="">
// 				<option value="1">Bucuresti</option>
// 				<option value="2">Brasov</option>
// 				<option value="3">Cluj</option>
// 			</select>
// 		</div>

// 	</div>
// </fieldset>
// }
