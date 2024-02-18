
class Typewriter {
    constructor(el, options){
        this.el = el;
        this.words = [...this.el.dataset.typewriter.split('|')];
        this.speed = options?.speed || 100;
        this.delay = options?.delay || 1500;
        this.repeat = options?.repeat;
        this.initTyping();
    }

    stop ()
    {
        this.el = null;
        delete this;
    }

    wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms))

    //toggleTyping = () => this.el.classList.toggle('typing');
    toggleTyping ()
    {
        if (this.el)
        {
            this.el.classList.toggle('typing');
        }
    }

    async typewrite(str){
        await this.wait(this.delay);
        this.toggleTyping();

        for (const letter of str.split(' ')) {
            if (this.el)
            {
                this.el.innerHTML += letter + ' ';
                await this.wait(this.speed);
            }
            else {
                break;
            }
        }
        /*
        this.toggleTyping();
        await this.wait(this.delay);
        this.toggleTyping();
        while (this.el.textContent.length !== 0){
            this.el.textContent = this.el.textContent.slice(0, -1);
            await this.wait(this.speed)
        }
        this.toggleTyping();
        */
    }

    async initTyping() {
        for (const word of this.words){
            await this.typewrite(word);
        }
        if (this.repeat) {
            await this.initTyping();
        } else {
            if (this.el) {
                this.el.style.animation = 'none';
            }
        }
    }
}

