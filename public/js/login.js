var loadingDiv = document.getElementById('loading');

$('form.form-login').submit(function() {
    var submitBtn = this["submit"],
        formData = $(this).serialize();

    loadingDiv.style.display = 'block';
    $('fieldset').prop('disabled', true);

    $.post(this.action, formData, function(response) {
        try {
            if (JSON.parse(response)) location.reload();
            else {
                submitBtn.classList.add('wrong');
                setTimeout(function() {
                    submitBtn.classList.remove('wrong')
                }, 501);
            }
        } catch (e) {
            console.error("Error"); // To Remove ?
        }
        loadingDiv.style.display = 'none';
        $('fieldset').prop('disabled', false);
    });
    return false;
});