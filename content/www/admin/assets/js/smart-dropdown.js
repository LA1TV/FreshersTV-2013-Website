// removes instructional row from dropdown after user has chosen something
(function($)
{

    $(document).ready(function(e)
    {
        
        $("select.smart-dropdown").each(function()
        {
            var self=this;
            
            runCheck();
            
            $(this).change(runCheck);
            
            function runCheck()
            {
                var chosenId = $(self).find(":selected").attr('value');
                if(chosenId != '')
                {
                    $(self).find("option[value='']").prop('disabled', true).prop('hidden', true);
                }
            }
        });
    });
})(jQuery); 