(function () {
  const formSelect = document.querySelector('.form__field--select');
  const formSubmitBtn = document.querySelector('.form__field--submit');
  const acfFieldsArea = document.querySelector('.form__acf-fields');
  formSelect.addEventListener('change', function () {
    const value = this.value;
    if (value) {
      this.disabled = true;
      formSubmitBtn.disabled = true;

      jQuery.post(
        ajaxurl,
        { action: 'cdi_acf_group_action', post_type: value },
        function (data) {
          formSelect.disabled = false;
          formSubmitBtn.disabled = false;

          const parseData = JSON.parse(data);

          if (parseData.length > 0) {
            addHeaderMessage(acfFieldsArea);
            addField(acfFieldsArea, { label: 'Post Title' });

            parseData.forEach(function (field) {
              addField(acfFieldsArea, field);
            });
          } else {
            addEmptyFieldMessage(acfFieldsArea);
          }
        }
      );
    }
  });

  function addHeaderMessage(acfFieldsArea) {
    const headerMessage = document.createElement('p');
    headerMessage.classList.add('header-message');
    headerMessage.innerText = 'Please provide CSV column number in each field.';
    appendToACFFieldsArea(acfFieldsArea, headerMessage);
  }

  function addField(acfFieldsArea, field) {
    const formBlock = createFormBlock();
    const fieldLabel = createFieldLabel(field.label);
    const columnField = createColumnField();

    appendToFormBlock(formBlock, fieldLabel);
    appendToFormBlock(formBlock, columnField);
    appendToACFFieldsArea(acfFieldsArea, formBlock);
  }

  function addEmptyFieldMessage(acfFieldsArea) {
    const emptyFieldMessage = document.createElement('p');
    emptyFieldMessage.classList.add('header-message', 'header-message--empty');
    emptyFieldMessage.innerText = 'No ACF Group fields found.';
    appendToACFFieldsArea(acfFieldsArea, emptyFieldMessage);
  }

  function createFormBlock() {
    const formBlock = document.createElement('div');
    formBlock.classList.add('form__block');
    return formBlock;
  }

  function createFieldLabel(label) {
    const fieldLabel = document.createElement('label');
    fieldLabel.innerText = label;
    return fieldLabel;
  }

  function createColumnField() {
    const columnField = document.createElement('input');
    columnField.type = 'number';
    columnField.min = 1;
    columnField.name = 'cdi-field[]';
    columnField.classList.add('form__field');
    return columnField;
  }

  function appendToFormBlock(formBlock, eL) {
    formBlock.appendChild(eL);
  }

  function appendToACFFieldsArea(acfFieldsArea, eL) {
    acfFieldsArea.appendChild(eL);
  }
})();
