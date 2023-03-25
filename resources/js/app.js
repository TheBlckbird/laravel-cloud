import './bootstrap';
import 'normalize.css';

const newFileButton = document.getElementById('new_file_button')
const newFolderButton = document.getElementById('new_folder_button')

const newFileMenu = document.getElementById('new_file_menu')
const newFolderMenu = document.getElementById('new_folder_menu')

newFileButton.addEventListener('click', (e) => {
    if (newFileMenu.classList.contains('hidden')) {
        newFileMenu.classList.remove('hidden')
        newFolderMenu.classList.add('hidden')

    } else {
        newFileMenu.classList.add('hidden')
    }
})

newFolderButton.addEventListener('click', (e) => {
    if (newFolderMenu.classList.contains('hidden')) {
        newFileMenu.classList.add('hidden')
        newFolderMenu.classList.remove('hidden')

    } else {
        newFolderMenu.classList.add('hidden')
    }
})


const fileInput = document.getElementById('new_file')
fileInput.addEventListener('input', (e) => {
    const file = fileInput.files[0]
    isThisAFile(file)
        .then(validFile => console.log('Woohoo! Got a File:', validFile))
        .catch(error => {
            alert("Folders aren't supported!")
            fileInput.value = null
        })

})

function isThisAFile(maybeFile) {
    return new Promise(function (resolve, reject) {
        if (maybeFile.type !== '') {
            return resolve(maybeFile)
        }
        const reader = new FileReader()
        reader.onloadend = () => {
            if (
                reader.error &&
                (
                    reader.error.name === 'NotFoundError' ||
                    reader.error.name === 'NotReadableError'
                )) {
                return reject(reader.error.name)
            }
            resolve(maybeFile)
        }
        reader.readAsBinaryString(maybeFile)
    })
}
