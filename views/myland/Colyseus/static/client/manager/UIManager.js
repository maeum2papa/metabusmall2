class UIManager {           
    static instance;
    arrElement = [];
    constructor() {
    }
    static getInstance() {
        if (!UIManager.instance) {
            UIManager.instance = new UIManager();
        }

        return UIManager.instance;
    }

    setElement(element) {
        let index = this.arrElement.findIndex(ele => ele === element);
        if(index !== -1) return;

        this.arrElement.push(element);
        for(let i = 0; i < this.arrElement.length; ++i) {
            let zindex = 1000 + i;
            this.arrElement[i].style.zIndex = zindex;
        }
    }

    removeElement(element) {
        let index = this.arrElement.findIndex(ele => ele === element);
        if(index !== -1) {
            this.arrElement.splice(index,1);
        }
    }

    selectElement(element) {
        let index = this.arrElement.findIndex(ele => ele === element);
        if(index !== -1 && index !== this.arrElement.length - 1) {
            this.arrElement.splice(index,1);
            this.arrElement.push(element);

            for(let i = 0; i < this.arrElement.length; ++i) {
                this.arrElement[i].style.zIndex = 1000 + i;
            }
        }
    }

    popBackElement() {
        if(this.arrElement.length > 0) {
            let ele = this.arrElement.splice(this.arrElement.length - 1, 1);
            ele[0].style.display = 'none';            
        }
    }
 
}