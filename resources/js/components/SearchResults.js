import React, {Component} from "react";
import {Thumbnail} from "./Thumbnail";
import {VideoPlayer} from "./VideoPlayer";


export class SearchResults extends Component {

    constructor(props) {
        super(props)

        this.state = {
            results: [],
            resultsLoaded: this.props.resultsLoaded | false,
            videoId: '',
            showVideo: false,
        }
        this.showVideo = this.showVideo.bind(this);

    }

    renderResults(){

        return this.props.results.map((results, i) => {
            return <><Thumbnail key={i} title={results.title} id={results.id} thumbnail={results.thumbnail} showVideo={this.showVideo}/></>
        })
    }

    showVideo(id) {

        this.setState(prevState => (
            {
                ...prevState,
                videoId: id ,
                showVideo: !prevState.showVideo,
            })
        );

    }


    render() {
        return (
            <div className={'row'}>
                <div className={"searchResults card-columns"}>
                    { !this.props.error &&
                        this.renderResults()
                    }
                    { this.props.error &&
                        <div className={'alert alert-danger'}>{this.props.error}</div>
                    }
                </div>
                <VideoPlayer id={this.state.videoId} showPlayer={this.state.showVideo} hideVideo={this.showVideo}/>
            </div>

        )
    }
}
