export class NameForm extends React.Component
{
    constructor(props)
    {
        super(props);
        this.name = React.createRef();

        this.submittedHandler = this.submittedHandler.bind(this);
    }

    submittedHandler(e)
    {
        alert("The submitted name: " + this.name.current.value);
        e.preventDefault();
    }

    render()
    {
        return (
            <form onSubmit={this.submittedHandler}>
                <label>Name: </label>
                <input ref={this.name}/>
                <input type="submit"/>
            </form>
        );
    }
}

console.log("Successfully imported valiant.js");
