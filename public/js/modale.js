/* ***********************************
        * MODALE DELETE
*********************************** */

// const deleteBtns = document.querySelectorAll('.destroy');
// const closeBtns = document.querySelectorAll('.modale__exit');
const deleteBtn = document.querySelector('.modale');
const closeBtn = document.querySelector('.modale__exit');
const modale = document.querySelector('.modale__modale');
const overLay = document.querySelector('.screen');


//? per show page:
if (deleteBtn) {
    
    deleteBtn.addEventListener('click', function (e) {
        e.preventDefault();

        modale.classList.remove('holding');
        document.body.classList.add('no-scroll');
        overLay.classList.add('active');
    
    });

}

//? per show page:
if (closeBtn) {

    closeBtn.addEventListener('click', function(e){
        e.preventDefault();

        console.log('ho cliccato il bottone closed');
        modale.classList.add('holding');
        document.body.classList.remove('no-scroll');
        overLay.classList.remove('active');
    
    });
}

//? per index page:
// deleteBtns.forEach(Button => {
//     Button.addEventListener('click', function(e){
//         e.preventDefault();
      
//         const buttonSlug = Button.getAttribute('data-slug');
//         console.log(`Cancella: ${buttonSlug}`);

//         const modaleDelete = document.getElementById(`modale-${buttonSlug}`);
//         console.log(modaleDelete);

//         if (modaleDelete) {
//             modaleDelete.classList.remove('holding');
//             document.body.classList.add('no-scroll');
//             overLay.classList.remove('screen');

//             window.scrollTo(0, 0);

//         };

//     });

// });

//? index page:
// closeBtns.forEach(Button => {
//     Button.addEventListener('click', function(e) {
//         e.preventDefault();

//         const modale = Button.closest('.modale__modale');
//         modale.classList.add('holding');
//         document.body.classList.remove('no-scroll');
//         overLay.classList.add('screen');

//     })
// })

//TODO: iserire in pagina la modale:
/*

<a href="{{$project->slug}}" class="modale" data-slug="{{$project->slug}}">
    <i class="fas fa-trash"></i>
</a>  

{{--? modale --}}
<div class="modale__modale holding" id="modale-{{$project->slug}}">
    <span class="modale__exit">CHIUDI</span>
    <h4>Sei sicuro di voler cancellare?</h4>
    <p>La cancellazione è irreversibile</p>
    <form id="delete-form-{{$project->slug}}" action="{{route('admin.projects.destroy', $project->slug)}}" method="POST">
        @csrf
        @method('DELETE')
        <input class="delete" type="submit" value="Elimina Elemento">
    </form>
</div>

*/