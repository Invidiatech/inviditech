 
function toggleAnswerFields() {
    const answerType = document.getElementById('answerType').value;
    
    // Hide all fields first
    document.querySelectorAll('.answer-field').forEach(field => {
        field.style.display = 'none';
    });
    
    // Show the appropriate field based on the selected answer type
    if (['select', 'radio', 'checkbox'].includes(answerType)) {
        document.getElementById('optionsField').style.display = 'block';
    } else if (answerType === 'text') {
        document.getElementById('textInputField').style.display = 'block';
    } else if (answerType === 'textarea') {
        document.getElementById('textareaField').style.display = 'block';
    } else if (answerType === 'number') {
        document.getElementById('numberField').style.display = 'block';
    } else if (answerType === 'date') {
        document.getElementById('dateField').style.display = 'block';
    }
}

function addOption() {
    const container = document.getElementById('options-container');
    const optionCount = container.querySelectorAll('.input-group').length;
    const letterCode = 65 + optionCount; // ASCII code for A is 65
    const letter = String.fromCharCode(letterCode);
    
    const newOption = document.createElement('div');
    newOption.className = 'input-group mb-2';
    newOption.innerHTML = `
        <input type="text" name="options[]" class="form-control rounded-start shadow-sm" placeholder="Type...">
        <span class="input-group-text text-white option-btn fw-bold" style="background-color: #53C0CA;">Option ${letter}</span>
        <button type="button" class="btn rounded-end" onclick="removeOption(this)">
            <i class="bx bx-trash"></i>
        </button>
    `;
    container.appendChild(newOption);
}

function removeOption(button) {
    const container = document.getElementById('options-container');
    const optionDiv = button.closest('.input-group');
    
    // Don't allow removing if there are fewer than 2 options
    if (container.querySelectorAll('.input-group').length > 2) {
        container.removeChild(optionDiv);
        
        // Update the option letters after removing
        const options = container.querySelectorAll('.input-group');
        options.forEach((option, index) => {
            const letter = String.fromCharCode(65 + index);
            const optionBtn = option.querySelector('.option-btn');
            if (optionBtn) {
                optionBtn.textContent = 'Option ' + letter;
            }
        });
    } else {
        alert('You need to keep at least 2 options');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleAnswerFields();
});