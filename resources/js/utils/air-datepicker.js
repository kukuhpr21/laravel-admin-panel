import AirDatepicker from 'air-datepicker';
import 'air-datepicker/air-datepicker.css';
import {createPopper} from '@popperjs/core';
import localeEn from 'air-datepicker/locale/en';


export const initAirDatepickerSingle = (el, dateFormat = 'yyyy-MM-dd', ) => {
    new AirDatepicker('#'+el, {
        // container: '#'+container,
        dateFormat: dateFormat,
        buttons: ['today', 'clear'],
        locale: localeEn,
        isMobile: true,
        position({$datepicker, $target, $pointer, done}) {
            let popper = createPopper($target, $datepicker, {
                placement: 'top',
                modifiers: [
                    {
                        name: 'flip',
                        options: {
                            padding: {
                                top: 64
                            }
                        }
                    },
                    {
                        name: 'offset',
                        options: {
                            offset: [0, 20]
                        }
                    },
                    {
                        name: 'arrow',
                        options: {
                            element: $pointer
                        }
                    }
                ]
            })

            /*
             Return function which will be called when `hide()` method is triggered,
             it must necessarily call the `done()` function
              to complete hiding process
            */
            return function completeHide() {
                popper.destroy();
                done();
            }
        }
    })
}
