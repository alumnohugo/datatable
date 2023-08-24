import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje  } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.querySelector('form')
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('divTabla');

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

let contador = 1;
const datatable = new Datatable('#tablaClientes', {
    language : lenguaje,
    data : null,
    columns: [
        {
            title : 'NO',
            render : () => contador ++
            
        },
        {
            title : 'NOMBRE',
            data: 'cliente_nombre'
        },
        {
            title : 'NIT',
            data: 'cliente_nit',
            
            // render : (data) => 'Q. ' + data
        },
        {
            title : 'MODIFICAR',
            data: 'cliente_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["cliente_nombre"]}' data-nit='${row["cliente_nit"]}'>Modificar</button>`
        },
        {
            title : 'ELIMINAR',
            data: 'cliente_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },

    ]
})

const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['cliente_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }

    const body = new FormData(formulario)
    body.delete('cliente_id')
    const url = '/datatable/API/clientes/guardar';
    const headers = new Headers();
    headers.append("X-Requested-With","fetch");
    const config = {
        method: 'POST',
        // body: otroNombre
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        // console.log(data);
        // return

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                break;

            case 0:
                icon = 'error'
                console.log(detalle)
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const buscar = async () => {

    const url = `/datatable/API/clientes/buscar`;
    const config = {
        method : 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        datatable.clear().draw()
        if(data){
            datatable.rows.add(data).draw();
        }else{
            Toast.fire({
                title : 'No se encontraron registros',
                icon : 'info'
            })
        }
       
    } catch (error) {
        console.log(error);
    }
}

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id
    const nombre = button.dataset.nombre
    const precio = button.dataset.precio

    console.log(id, nombre, precio);
}


const eliminar = e => {
    const button = e.target;
    const id = button.dataset.id
    console.log(id);
}

buscar();



const colocarDatos = (datos) => {
    formulario.arma_nombre.value = datos.arma_nombre
    // formulario.arma_precio.value = datos.arma_precio
    formulario.arma_id.value = datos.arma_id
    
    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none'
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none'
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = ''
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = ''
    divTabla.style.display = 'none'
    
    // modalEjemploBS.show();
}



    


formulario.addEventListener('submit', guardar)
// btnBuscar.addEventListener('click', buscar)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )