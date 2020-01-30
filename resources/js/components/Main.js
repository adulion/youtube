import React, {Component} from 'react';
import ReactDOM from 'react-dom'
import {Search} from "./Search";
import {SearchResults} from "./SearchResults";
import {VideoPlayer} from "./VideoPlayer";


export class Main extends Component {


    constructor(props) {
        super(props)

        this.state = {
            searchResults: [],
            isLoading: false,
            error: false
        }
        this.handleSearch = this.handleSearch.bind(this);

    }

    makeAndHandleRequest(query, page = 1) {
        return fetch(`/api/v1/search?search_term=${query}`)
            .then((resp) => {
                if (resp.status == 429) {
                    throw new Error("Quota limit exceeded")
                } else return (resp.json());
            }).then((result) => {
                const searchResults = result.data.map((i) => ({
                    title: i.title,
                    id: i.id,
                    thumbnail: i.thumbnail,
                }));
                return searchResults;
            }).catch(error => {
                this.setState({
                    isLoading: false,
                    error: error.message
                });
            });
    }

    handleChange(e) {
        const {checked, name} = e.target;
        this.setState({[name]: checked});
    }

    handleSearch(query) {
        this.setState({isLoading: true});
        this.makeAndHandleRequest(query)
            .then((searchResults) => {
                this.setState({
                    isLoading: false,
                    searchResults,
                });
            });
    }



    render() {
        return (
            <div>
                <Search searchYoutube={this.handleSearch}/>
                <SearchResults results={this.state.searchResults}  error={this.state.error}/>
            </div>
        )
    }
}


ReactDOM.render(<Main/>, document.getElementById('app'))
