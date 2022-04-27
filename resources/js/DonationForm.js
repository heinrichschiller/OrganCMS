const DonationForm = (function () {
  const work = document.querySelector('#work')
  const register = document.querySelector('#register')
  const sound = document.querySelector('#sound')

  let setupEventListeners = () => {
    toggleWorkSelector()
    selectOrganRegister()
    selectOrganSound()
    createRecipients()
    toggleRecipientsInput()
  }

  let toggleWorkSelector = () => {
    const wishPipe = document.querySelector('#wishorganpipe')

    wishPipe.addEventListener('click', () => {
      if (null !== work) {
        work.removeAttribute('disabled')

        let req = new XMLHttpRequest()
  
        req.onload = () => {
          if (200 === req.status) {
            let json

            if ('json' === req.responseType) {
              json = req.response
            } else {
              json = JSON.parse(req.responseText)
            }

            let works = json.work
            works.forEach(elem => {
              let option = document.createElement('option')
              option.text = elem.name
              work.add(option)

              let val = document.createAttribute('value')
              val.value = elem.name
              option.setAttributeNode(val)
            })
          }
        }

        req.open('GET', 'https://127.0.0.1:8000/api/v1/work', true)
        req.responseType = 'json'
        req.setRequestHeader('Accept', 'application/json')
        req.send()
      }
    })
  }

  let selectOrganRegister = () => {
    
    if (null !== work) {
      work.addEventListener('change', () => {

        let length = register.options.length;
        for(let i = length - 1; i >= 0; i--) {
          register.remove(i);
        }

        let option = document.createElement('option');
        let disabled = document.createAttribute('disabled');
        let selected = document.createAttribute('selected');
        let hidden   = document.createAttribute('hidden');

        option.text = 'Register';
        option.setAttributeNode(disabled);
        option.setAttributeNode(selected);
        option.setAttributeNode(hidden);
        register.add(option);

        let req = new XMLHttpRequest()

        req.onload = () => {
          if(200 === req.status) {
            let json

            if ('json' === req.responseType) {
              json = req.response
            } else {
              json = JSON.parse(req.responseText)
            }

            let registers = json.register
            registers.forEach(elem => {
              let option = document.createElement('option')
              option.text = elem.name
              register.add(option)

              let val = document.createAttribute('value')
              val.value = elem.name
              option.setAttributeNode(val)
            })
          }
        }
        
        req.open('GET', 'https://127.0.0.1:8000/api/v1/register/' + work.value, true)
        req.responseType = 'json'
        req.setRequestHeader('Accept', 'application/json')
        req.send()

        register.removeAttribute('disabled')
      })
    }
  }

  let selectOrganSound = () => {
    if (null !== sound) {
      register.addEventListener('change', () => {

        while(sound.options.length > 0) {
          sound.remove(0)
        }

        let option = document.createElement('option')
        let disabled = document.createAttribute('disabled')
        let selected = document.createAttribute('selected')
        let hidden = document.createAttribute('hidden')

        option.text = 'Ton'
        option.setAttributeNode(disabled)
        option.setAttributeNode(selected)
        option.setAttributeNode(hidden)
        sound.add(option)

        let req = new XMLHttpRequest()

        req.onload = () => {
          if (200 === req.status) {
            let json

            if ('json' === req.responseType) {
              json = req.response
            } else {
              json = JSON.parse(req.responseText)
            }

            let sounds = json.sound
            sounds.forEach(elem => {
              let option = document.createElement('option')
              option.text = `${elem.name}: ${elem.price} €`
              sound.add(option)

              let val = document.createAttribute('value')
              val.value = elem.name
              option.setAttributeNode(val)
            })
          }
        }

        req.open('GET', 'https://127.0.0.1:8000/api/v1/sound/'
          + work.value 
          + '/' + register.value.replace(/\//g, '-')
          , true)
        req.responseType = 'json'
        req.setRequestHeader('Accept', 'application/json')
        req.send()

        sound.removeAttribute('disabled')
      })
    }
  }

  let toggleRecipientsInput = () => {
    const pipeAsGift = document.querySelector('#pipe__as__gift')

    if (null !== pipeAsGift) {
      pipeAsGift.addEventListener('click', () => {
        document.querySelector('#name__recipient').toggleAttribute('disabled')
        document.querySelector('#btn__new__recipient').toggleAttribute('disabled')
      })
    }
  }

  let createRecipients = () => {
    const recipients = document.querySelector('#recipients')
    const recipientsInput = document.querySelector('#btn__new__recipient')

    if (null !== recipientsInput) {
      recipientsInput.addEventListener('click', () => {
        let rowElem = document.createElement('div');
        rowElem.className = 'row'

        let colElem = document.createElement('div')
        colElem.className = 'col-md-11'

        let inputElem  = document.createElement('input')
        inputElem.name = 'name-recipients[]'
        inputElem.type = 'text'
        inputElem.classList = 'form-control mb-2'
        
        colElem.appendChild(inputElem)
        rowElem.appendChild(colElem)
        recipients.appendChild(rowElem)
      })
    }
  }

  return {
    run() {
      setupEventListeners()
    }
  }
})()

export default DonationForm