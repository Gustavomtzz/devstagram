import Dropzone from "dropzone";
import { fromJSON } from "postcss";

Dropzone.autoDiscover = false;

if (document.querySelector('#dropzone')) {
    const dropzone = new Dropzone('#dropzone', {
        dictDefaultMessage: "Sube aquí tu imagen",
        acceptedFiles: ".png, .jpg, .jpeg, .gif",
        addRemoveLinks: true,
        dictRemoveFile: "Borrar Archivo",
        maxFiles: 1,
        uploadMultiple: false,

        init: function () {

            if (document.querySelector('#imagen').value.trim()) {

                const imagenPublicada = {};
                imagenPublicada.size = 1234;
                imagenPublicada.name = document.querySelector('#imagen').value.trim();

                this.options.addedfile.call(this, imagenPublicada);
                this.options.thumbnail.call(this, imagenPublicada, ` /uploads/${imagenPublicada.name}`);

                imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
            }


        }
    });

    // dropzone.on('sending', function (file, xhr, formdata) {
    //     console.log(formdata)
    // })

    dropzone.on('success', function (file, response) {
        //Obtener el Input
        const $imagen = document.querySelector('#imagen');
        //Agregar el uuid de la imagen al input
        $imagen.setAttribute('value', response.imagen);

    })

    // dropzone.on('error', function (file, message) {
    //     console.log(message)
    // })

    dropzone.on('removedfile', function () {
        //Obtener el Input
        const $imagen = document.querySelector('#imagen');
        //Eliminar el uuid de la imagen al input
        $imagen.setAttribute('value', '');
    })

}


(function eventos() {
    const btnEditarComentario = document.querySelectorAll('#btnComentarioEditar')

    btnEditarComentario.forEach(function (boton) {
        boton.addEventListener('click', editarComentario)
    })
})()

function editarComentario(e) {

    const btnEditar = e.target
    const comentarioContenido = e.target.parentNode.parentNode.querySelector('#pComentario').textContent.trim()
    const comentarioID = e.target.getAttribute('data-id')
    const formularioCrear = document.querySelector('#formularioCrearComentario')
    const formularioEditar = document.querySelector('#formularioEditarComentario')
    const textArea = formularioEditar.querySelector('#comentario')
    const urlActual = window.location.origin

    btnEditar.classList.toggle('checked')

    if (btnEditar.classList.contains('checked')) {
        //Estilos Agregar o Remover
        btnEditar.classList.add('text-green-500')
        formularioCrear.classList.add('hidden')
        formularioEditar.classList.remove('hidden')

        //Agregar Action al Formulario
        formularioEditar.setAttribute('action', `${urlActual}/comentarios/${comentarioID}`)

        //Rellenar el TextArea con el comentario anterior    
        textArea.textContent = comentarioContenido

        textArea.addEventListener('input', comentarioNuevo)
    }

    else {
        btnEditar.classList.remove('text-green-500')
        formularioCrear.classList.remove('hidden')
        formularioEditar.classList.add('hidden')
    }


}

function comentarioNuevo(e) {
    const formularioEditar = document.querySelector('#formularioEditarComentario')
    const submit = formularioEditar.querySelector('input[type ="submit"]')

    //Actualizar el comentario 
    e.target.textContent = e.target.value


    //Si el comentario no esta vacio seteamos el action del form y enviamos el Formulario
    if (e.target.value != '') {
        submit.addEventListener('click', () => {
            formularioEditar.submit()
        })
    }
}