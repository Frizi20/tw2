class SurveyBuilder {
  allFields
  allFieldsDOM = []

  draggedField
  fieldIsDragged = false
  pointerX
  pointerY
  fieldX
  fieldY
  lastHoveredOver

  saveCallback

  constructor(schema) {
    this.formBuilderDOM = document.querySelector('.form-builder')
    this.addFormFieldBtn = document.querySelector('.add-form-field')
    this.saveSchemaBtn = document.querySelector('.save-schema')

    this.bindedNewField = this._addNewFeild.bind(this)
    this.bindedGetSchema = this.getJsonSchema.bind(this)

    this.addFormFieldBtn.addEventListener('click', this.bindedNewField)
    this.saveSchemaBtn.addEventListener('click', this.bindedGetSchema)

    this.allFields = this._sortFields(schema)

    this._createFields()

    this._sortFields(this.allFields)
  }

  remove() {
    this.allFieldsDOM.forEach((domEl) => domEl.remove())
    this.allFields.length = 0
    this.addFormFieldBtn.removeEventListener('click', this.bindedNewField)
    this.saveSchemaBtn.removeEventListener('click', this.bindedGetSchema)
  }

  addSaveCallback(callback) {
    this.saveCallback = callback
  }

  getJsonSchema() {
    const exportJSON = JSON.stringify({ fields: this.allFields }, null, 2)
    this.saveCallback(exportJSON)
  }

  _createFields() {
    this.allFields.forEach((field, index) => {
      const id = this._createInputId(10)

      //Create DOM field with unique id to be synced with the allFieldsSchema
      const createdField = this._createField(field, id, index)

      //update each field prop with the unique id in the input DOM dataset
      field.id = id

      //store all created inputs
      this.allFieldsDOM.push(createdField)

      //add delete option for the field
      this._addDeleteEvent(createdField)

      //add delete option event
      this._addDeleteOptionEvent(createdField)

      //add edit event
      this._addEditEvent(createdField)

      //add the add+ option functionality
      this._addAugmentOpion(createdField)

      //add update description
      this._addUpdateTitleEvent(createdField)

      //add update option value event
      this._addUpdateOptionValue(createdField)

      //add update label event
      this._addUpdateOptionLabel(createdField)

      //add draggable functionality to every field
      this._addDraggingEvents(createdField)
    })
  }

  _addDraggingEvents(fieldDOM) {
    if (!this.mouseMoveEvent) {
      window.addEventListener('mousemove', this._moveEl.bind(this), true)
      this.mouseMoveEvent = true
    }
    if (!this.mouseUpEvent) {
      window.addEventListener('mouseup', this._clickUp.bind(this), true)
      this.mouseUpEvent = true
    }
    fieldDOM.addEventListener('mousedown', this._clickDown.bind(this), true)
  }

  _clickDown(e) {
    const element = e.target
    if (!element.className.includes('form-field')) return

    const { width, height, left, top } = element.getBoundingClientRect()

    // this.fieldClone = element.cloneNode(true)
    // this.fieldClone.style.visibility = 'hidden'

    //Create dummy div that fills the space created by the dragged one
    const dummyDiv = document.createElement('div')
    this.dummyDiv = dummyDiv

    dummyDiv.style.height = height + 20 + 'px' // +20 represents the element's margin-top
    dummyDiv.style.width = width + 'px'

    element.parentElement.insertBefore(dummyDiv, element.nextElementSibling)

    // Set dragged element to his inital position by fixed perspective
    Object.assign(element.style, {
      position: 'fixed',
      width: `${width}px`,
      height: `${height}px`,
      left: `${window.scrollX + left}px`,
      top: `${top - 20}px`,
      zIndex: 200,
      opacity: 0.8,
    })

    this.pointerX = e.clientX
    this.pointerY = e.clientY
    this.elInitialX = left
    this.elInitialY = top - 20

    this.fieldIsDragged = true
    this.draggedField = element
  }

  _scrollEl(el) {
    // el.scrollBy(0, -20)
    console.log(el)
  }

  _addScrollInterval(el) {
    this.scrollInterval = setInterval(function () {
      console.log('....')
      // el.scrollBy(0, -20)
    }, 1000)
  }

  _moveEl(e) {
    if (!this.fieldIsDragged) return

    const fieldContainer = this.draggedField.parentElement

    const moveX = (this.pointerX - e.clientX) * -1
    const moveY = (this.pointerY - e.clientY) * -1

    const currX = this.pointerX
    const currY = this.pointerY
    const elementCurrentX = this.elInitialX + moveX
    const elementCurrentY = this.elInitialY + moveY
    const {
      left: currElX,
      top: currElY,
      height: currElHeight,
      width: currElWidth,
    } = this.draggedField.getBoundingClientRect()
    const {
      top: fieldContainerTop,
      height: fieldContainerHeight,
    } = fieldContainer.getBoundingClientRect()
    this.draggedField.style.left = elementCurrentX + 'px'
    this.draggedField.style.top = elementCurrentY + 'px'
    // this.draggedField.style.position = 'fixed'
    // this.draggedField.style.transform = currY - e.clientY

    //Scroll field up if the dragged element is hovered over

    //Field collision logic
    this.allFieldsDOM.map((draggable, i) => {
      const {
        left: draggableX,
        top: draggableY,
        height: draggableHeight,
        width: draggableWidth,
      } = draggable.getBoundingClientRect()

      if (draggable !== this.draggedField) {
        // if(i === 1){
        // 	console.log((currElY + currElHeight) > draggableY && currElY < draggableY + draggableHeight )
        // }

        // if(((currElHeight + currElY - 65)> draggableY) &&
        // 	currElY + 65 < draggableY + draggableHeight){

        if (
          currElY + 65 > draggableY &&
          currElY + 65 < draggableY + draggableHeight
        ) {
          // draggable.style.opacity = 0.3
          if (!draggable.className.includes('over')) {
            draggable.classList.add('over')
            // draggable.style.background = 'red'
            this.lastHoveredOver = draggable
          }
          // allDraggables.lastDraggedOverEl = draggable.draggedElement
          // this.lastDragged = draggable.draggedElement
          // draggable.draggedElement.style.opacity = 0.5
        } else {
          draggable.classList.remove('over')
        }
      }
    })
  }

  _clickUp(e) {
    // if(!e.target.className.includes('form-field')) return
    this.fieldIsDragged = false
    if (!this.draggedField) return

    //set the dragged element style to normal
    Object.assign(this.draggedField.style, {
      position: 'relative',
      width: 'auto',
      height: 'auto',
      left: 0,
      top: 0,
      zIndex: 0,
      opacity: 1,
    })

    //remove dummy div
    this.dummyDiv.remove()
    // this.fieldClone.remove()

    //remove style of the element hovered by the dragged one
    if (this.lastHoveredOver) {
      const hoveredIsFirst = !this.lastHoveredOver.previousElementSibling.className.includes(
        'form-field',
      )
      this.lastHoveredOver.classList.remove('over')

      //place the dragged element behind the one that's hovered over
      this.draggedField.parentNode.insertBefore(
        this.draggedField,
        hoveredIsFirst
          ? this.lastHoveredOver
          : this.lastHoveredOver.nextElementSibling,
      )

      //sync the order of the allFieldsDOM with the order in the new order DOM
      const movedFieldIndex = this.allFieldsDOM.findIndex(
        (field) => field === this.draggedField,
      )
      const lastHoveredIndex = this.allFieldsDOM.findIndex(
        (field) => field === this.lastHoveredOver,
      )

      //sort the allFieldsDOM if the hovered element is the first
      if (movedFieldIndex - lastHoveredIndex !== 1 || hoveredIsFirst) {
        this.allFieldsDOM.splice(movedFieldIndex, 1)
        this.allFieldsDOM.splice(lastHoveredIndex, 0, this.draggedField)
      }
    }

    // update the  fieldOrder property for every field element
    this.allFieldsDOM.forEach((domField, index) => {
      const fieldId = domField.getAttribute('data-input-id')
      const fieldToChange = this.allFields.find((field) => field.id == fieldId)
      fieldToChange.fieldOrder = index + 1
      domField.querySelector('.input-nr').textContent = index + 1 + '.'
    })

    this._sortFields(this.allFields)

    console.log(this.draggedField)

    this.lastHoveredOver = undefined
    this.draggedField = undefined

    if (this.intervalUp || this.intervalDown) {
      console.log('clearInterval')
      clearInterval(this.intervalUp)
      clearInterval(this.intervalDown)
    }
  }

  // _updateElNumerotation(){
  // 	domField.querySelector('.input-nr').textContent = index + 1 + '.'
  // }

  _sortFields(fields) {
    const sortedFields = fields.sort((a, b) => {
      return a.fieldOrder - b.fieldOrder
    })

    return sortedFields
  }

  _addNewFeild(e) {
    const btnClicked = e.target.closest('.add-form-field')
    if (!btnClicked) return
    const newId = this._createInputId(10)
    const newFieldOrder =
      this.allFields.length < 1
        ? 1
        : this.allFields[this.allFields.length - 1]?.fieldOrder + 1

    const fieldData = {
      title: '(Descriere)',
      fieldOrder: newFieldOrder || 1,
      options: [
        {
          value: '1',
          label: 'da',
        },
        {
          value: '2',
          label: 'nu',
        },
        {
          value: '3',
          label: 'partial',
        },
      ],
      id: newId,
    }

    //Add new field to the dom
    const createdNewField = this._createField(fieldData, newId)

    //push new Dom to the dom fields list
    this.allFieldsDOM.push(createdNewField)

    //add deete option for the new field
    this._addDeleteEvent(createdNewField)

    //add delete option event
    this._addDeleteOptionEvent(createdNewField)

    //add edit option
    this._addEditEvent(createdNewField)

    //add data to the state
    this.allFields.push(fieldData)

    //add the add+ option functionality
    this._addAugmentOpion(createdNewField)

    //add update description
    this._addUpdateTitleEvent(createdNewField)

    //add update option value event
    this._addUpdateOptionValue(createdNewField)

    //add update label event
    this._addUpdateOptionLabel(createdNewField)

    //add draggable functionality to every field
    this._addDraggingEvents(createdNewField)

    //Sroll field parent to bottom
    createdNewField.parentElement.scrollTo({
      top: createdNewField.parentElement.scrollHeight,
      behavior: 'smooth',
    })

    //update field order
    createdNewField.querySelector('.input-nr').textContent = newFieldOrder + '.'
  }

  _addAugmentOpion(createdField) {
    createdField
      .querySelector('.option-actions span')
      .addEventListener('click', this._addOption.bind(this))
  }

  _addDeleteEvent(createdField) {
    createdField
      .querySelector('.remove-input')
      .addEventListener('click', this._deleteField.bind(this))
  }

  _addUpdateTitleEvent(createdField) {
    createdField
      .querySelector('.edit-field-title .title')
      .addEventListener('change', this._updateTitle.bind(this))
  }
  _addUpdateOptionValue(createdField) {
    createdField
      .querySelectorAll('.option .value input')
      .forEach((optLabel) => {
        optLabel.addEventListener('change', this._updateValue.bind(this))
      })
  }

  _addUpdateOptionLabel(createdField) {
    createdField
      .querySelectorAll('.option .label input')
      .forEach((optLabel) => {
        optLabel.addEventListener('change', this._updateLabel.bind(this))
      })
  }

  _addDeleteOptionEvent(createdField) {
    createdField.querySelectorAll('.remove-option').forEach((delOption) => {
      delOption.addEventListener('click', this._deleteOption.bind(this))
    })
  }

  _updateTitle(e) {
    const descInput = e.target
    const currField = descInput.closest('.form-field')
    const fieldId = currField.dataset.inputId
    const fieldLabelDOM = currField.querySelector('.field-label')
    const currFieldState = this.allFields.find((field) => fieldId == field.id)

    // change field state
    currFieldState.title = descInput.value

    //change field description Value
    fieldLabelDOM.textContent = descInput.value
  }

  _updateLabel(e) {
    const labelInput = e.target
    const optionId = labelInput.closest('.option').dataset.optionId
    const currField = labelInput.closest('.form-field')
    const formFieldId = currField.dataset.inputId
    const currFieldState = this.allFields.find(
      (field) => field.id == formFieldId,
    )
    const currOptionState = currFieldState.options.find(
      (option) => option.id == optionId,
    )

    const optionDOM = currField.querySelector(
      `.form-group [data-option-id="${optionId}"]`,
    )

    console.log(optionDOM)
    //change the option label from state
    currOptionState.label = labelInput.value

    //change option label DOM
    optionDOM.textContent = labelInput.value
  }

  _updateValue(e) {
    const valueInput = e.target

    const optionId = valueInput.closest('.option').dataset.optionId
    const currField = valueInput.closest('.form-field')
    const formFieldId = currField.dataset.inputId
    const currFieldState = this.allFields.find(
      (field) => field.id == formFieldId,
    )
    const currOptionState = currFieldState.options.find(
      (option) => option.id == optionId,
    )

    const optionDOM = currField.querySelector(
      `.form-group [data-option-id="${optionId}"]`,
    )

    console.log(valueInput)
    //change the option label from state
    currOptionState.value = valueInput.value

    //change option label DOM
    console.log(optionDOM)
    optionDOM.value = valueInput.value
  }

  _addOption(e) {
    const addOptionBtn = e.target.closest('.option-actions span')
    if (!addOptionBtn) return
    const fieldID = addOptionBtn.dataset.inputId
    const newOptionId = this._createInputId(10)
    const newOptionData = {
      value: '',
      label: '',
      id: newOptionId,
    }

    const optionHTML = `<div class ="option" data-option-id="${newOptionId}">
                                <div class="label">
                                    <input type="text" value="${''}" placeholder="label" >
                                </div>
                                <div class="value">
                                    <input type="text" value="${''}" placeholder="value">
                                </div>
                                <div class="remove-option" data-option-id="${newOptionId}">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                            </div>`

    //Add new option to the field schema
    this.allFields
      .find((field) => fieldID == field.id)
      .options.push(newOptionData)

    //Add option to the DOM
    // --- Add DOM option to the edit Modal
    addOptionBtn.parentElement.insertAdjacentHTML('beforebegin', optionHTML)
    // --- Add DOM option to the select input preview
    const currSelect = document.querySelector(
      `.form-field[data-input-id="${fieldID}"] .form-group select`,
    )
    this._createSelectOption(currSelect, newOptionId)

    //add delete event to remove-option btn
    const removeBtn = document.querySelector(
      `.remove-option[data-option-id = "${newOptionId}"]`,
    )
    removeBtn.addEventListener('click', this._deleteOption.bind(this))

    //add update value and label events to the new option DOM
    const optionDom = document.querySelector(
      `.option[data-option-id="${newOptionId}"]`,
    )
    const updateLabelInput = optionDom.querySelector('.label input')
    const updateValueInput = optionDom.querySelector('.value input')

    updateLabelInput.addEventListener('change', this._updateLabel.bind(this))
    updateValueInput.addEventListener('change', this._updateValue.bind(this))
  }

  _createSelectOption(selectEl, newOptionId) {
    const optionHTML = `<option value="5" data-option-id="${newOptionId}"> </option>`
    selectEl.insertAdjacentHTML('beforeend', optionHTML)
  }

  _deleteOption(e) {
    const optionClicked = e.target.closest('.remove-option')
    if (!optionClicked) return
    const optionId = optionClicked.dataset.optionId
    const formFieldId = optionClicked.closest('.form-field').dataset.inputId

    //remove option from the edit DOM
    const currFieldState = this.allFields.filter((field) => {
      return field.id == formFieldId
    })

    //if there are less than one option stop removing the option
    if (currFieldState[0].options.length <= 2) return

    //remove option from the edit Modal DOM
    optionClicked.parentElement.remove()

    //remove option from the select preview
    document.querySelector(`option[data-option-id="${optionId}"]`).remove()

    //remove option from the field options in the schema
    const option = currFieldState[0].options.splice(
      currFieldState[0].options.findIndex((option) => option.id == optionId),
      1,
    )

    console.log(option)
  }

  _deleteField(e) {
    const btnClicked = e.target.closest('.remove-input')
    if (!btnClicked) return
    const id = btnClicked.dataset.inputId

    const formField = document.querySelector(
      `.form-field[data-input-id="${id}"]`,
    )
    //Add remove input animation
    formField.classList.add('removing')

    //Remove input from DOM
    setTimeout(() => {
      formField.remove()
    }, 250)

    //remove fromAllFields array
    this.allFields.splice(
      this.allFields.findIndex((field) => field.id === id),
      1,
    )

    //remove from allFieldsDOM
    this.allFieldsDOM.splice(
      this.allFieldsDOM.findIndex((fieldDOM) => fieldDOM == formField),
      1,
    )
  }

  _addEditEvent(createdField) {
    createdField
      .querySelector('.edit-input')
      .addEventListener('click', this._showEditModal.bind(this))
    createdField
      .querySelector('.close-options')
      .addEventListener('click', this._showEditModal.bind(this))
  }

  _showEditModal(e) {
    const closeOptionsBtn = e.target.closest('.close-options')
    const editInputBtn = e.target.closest('.edit-input')

    if (!closeOptionsBtn && !editInputBtn) return
    const btnClicked = closeOptionsBtn || editInputBtn

    console.log(btnClicked)

    const id = btnClicked.dataset.inputId

    const formField = document.querySelector(
      `.form-field[data-input-id="${id}"]`,
    )
    const input = formField.querySelector('.form-group')
    const label = formField.querySelector('.field-label')
    const editField = formField.querySelector('.edit-field')

    // hide input and label and show the edit modal

    input.classList.toggle('hidden')
    label.classList.toggle('hidden')
    editField.classList.toggle('active')
  }

  _createField(field, id, index) {
    let optionsIds = []

    const html = `
        <div class="form-field" data-input-id="${id}" draggable="false" data-fld-${
      field.fieldOrder
    }>

            <div class="input-nr">
                    ${index + 1 + '.'}
                </div>
            <label class="field-label"> ${field.title} </label>

            <div class="field-actions">
                <div class="edit-input" data-input-id="${id}">
                    <i class="fas fa-pen"></i>
                </div>
                <div class="remove-input" data-input-id="${id}">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
            <div class="form-group">
                <select>
                    ${field.options
                      .map((option, index) => {
                        const optionId = this._createInputId(10)
                        optionsIds.push(optionId)
                        return `<option value="${option.value}" data-option-id="${optionId}">
                                    ${option.label}
                                </option>`
                      })
                      .join('')}
                </select>
            </div>
            <div class="edit-field">
                <div class="edit-field-title">
                    <div class="description">
                        Descriere
                    </div>
                    <div class="title">
                        <textarea spellcheck="false">${field.title}</textarea>

                    </div>
                </div>
                <div class="edit-field-options">
                    <div class="description">
                        Options
                    </div>
                    <div class="options">

                        ${field.options
                          .map((option, index, optionsArr) => {
                            const optionId = optionsIds[index]

                            //Set option id to the schema
                            optionsArr[index]['id'] = optionId

                            return `<div class ="option" data-option-id="${optionId}">

                                <div class="label">
                                    <input type="text" value="${option.label}" placeholder="label">
                                </div>
                                <div class="value">
                                    <input type="text" value="${option.value}" placeholder="value" >
                                </div>
                                <div class="remove-option" data-option-id="${optionId}">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                            </div>`
                          })
                          .join('')}

                        <div class="option-actions">
                            <span data-input-id="${id}"> Add Option + </span>
                        </div>
                    </div>
                </div>
                <div class="close-options" data-input-id="${id}">
                    Close
                </div>
            </div>
        </div>`

    this.formBuilderDOM.insertAdjacentHTML('beforeend', html)

    return document.querySelector(`.form-field[data-input-id="${id}"]`)
  }

  _createInputId(randStringLength = 10) {
    if (!randStringLength || randStringLength < 1) return

    const alphabet = [...Array(26).keys()].map((i) =>
      String.fromCharCode(i + 97),
    )
    const nrs = [1, 2, 3, 4, 5, 6, 7, 8, 9]
    const hex = [...alphabet, ...nrs]
    const random = function () {
      return Math.floor(Math.random() * hex.length)
    }
    return [...Array(randStringLength)].map(() => hex[random()]).join('')
  }
}
