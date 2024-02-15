import { Controller } from '@hotwired/stimulus';
import SignaturePad from "signature_pad";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ['input', 'submitButton'];

    connect() {
        this.signaturePad = new SignaturePad(this.inputTarget);
        this.submitButtonTarget.disabled = true;
        this.submitButtonTarget.form.addEventListener('formdata', event => {
            event.formData.append('signature-image', this.signaturePad.toDataURL())
        });
        this.signaturePad.addEventListener('endStroke', () => {
            const points = this.signaturePad.toData().reduce((prev, stroke) => prev + stroke.points.length, 0)
            if (points > 20) {
                this.submitButtonTarget.disabled = false;
            }
        })
    }

    clear(event) {
        this.signaturePad.clear();
        this.submitButtonTarget.disabled = true;
    }
}
