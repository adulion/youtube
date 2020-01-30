import React, {Component} from "react";


export class Search extends Component {

    constructor(props) {
        super(props)

        this.state = {
            searchString :''
        }
        this.handleKeyDown = this.handleKeyDown.bind(this);

    }
    handleKeyDown(e){
        if (e.key === 'Enter') {
            this.props.searchYoutube(this.state.searchString)
        }
    }


    render() {
        return(
            <div className="md-form mt-5">
                <input className="form-control" type="text" placeholder="Search Youtube" aria-label="Search" onKeyDown={this.handleKeyDown} onChange={e => this.setState({ searchString: e.target.value })}/>
                <input type="button" className={"btn btn-primary"} value={"Search"} onClick={()=>this.props.searchYoutube(this.state.searchString)}/>
            </div>
        )
    }
}
