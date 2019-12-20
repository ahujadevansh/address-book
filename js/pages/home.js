$(function() {
    $('.modal').modal();

    $('.delete-contact').click(function(){
        let id = $(this).data('id');
        console.log(id);
        $('#delete-contact-id').val(id);
    });
});
function getURLVars()
{
    let vars = [];
    let hash;
    let hashes = window.location.href.slice(window.location.href.indexOf('?')+1).split('&');
    for(let i=0; i<hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars[hash[0]] = hash[1];
    }
    return vars;
}

let q = getURLVars()['q'];
let op = getURLVars()['op'];


if(q=='success' && op=='insert')
{
    M.toast({
        html: '<span>New Contact Created Successfully! (alert from js)</span>',
        classlist: 'black darken-1'
    });
}

if(q=='success' && op=='update')
{
    M.toast({
        html: '<span>Contact updated Successfully!</span>',
        classlist: 'Green darken-1'
    });
}

if(q=='success' && op=='delete')
{
    M.toast({
        html: '<span>Contact deleted Successfully!</span>',
        classlist: 'Green darken-1'
    });
}

if(q=='error' && op=='delete')
{
    M.toast({
        html: '<span>There is some error unable to delete Contact!</span>',
        classlist: 'red darken-1'
    });
}