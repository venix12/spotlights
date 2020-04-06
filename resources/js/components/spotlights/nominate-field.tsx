import React from 'react';
import { classModified } from '../../helpers/helpers';
import Axios from 'axios';
import { LoadingSpinner } from '../loading-spinner';
import { Alert } from '../alert';

interface Props {
    nominateBeatmap: any,
    spotlights: Spotlights,
    statistics: SpotlightsStatistic[],
}

interface State {
    beatmapsetUrl: string,
    comment: string,
    loading: boolean,
    message: string[],
}

class NominateField extends React.Component<Props, State> {
    state = {
        beatmapsetUrl: '',
        comment: '',
        loading: false,
        message: [],
    }

    closeMessage = () => {
        this.setState({
            message: [],
        });
    }

    handleInputChange = (event: React.ChangeEvent<HTMLInputElement> | React.ChangeEvent<HTMLTextAreaElement>) => {
        const newState: any = { [event.target.name]: event.target.value }

        this.setState(newState);
    }

    nominateBeatmap = async (event: React.FormEvent<HTMLFormElement>) => {
        const { spotlights } = this.props;
        const { beatmapsetUrl, comment } = this.state;

        event.preventDefault();

        this.setState({
            loading: true,
        })

        const beatmapsetId = this.parseBeatmapsetUrl(beatmapsetUrl);

        if (beatmapsetId.includes('error')) {
            this.setState({
                loading: false,
                message: beatmapsetId as string[],
            });

            return;
        }

        const response = await Axios.post(
            laroute.route('spotlights.store-nomination', { id: spotlights.id }),
            {
                comment: comment,
                id: beatmapsetId
            }
        );

        if (response.data[0] === 'error') {
            this.setState({
                loading: false,
                message: response.data,
            });
        } else {
            this.props.nominateBeatmap(response.data);

            this.setState({
                message: ['success', 'nominated a beatmap successfully!'],
            })
        }

        this.setState({
            beatmapsetUrl: '',
            comment: '',
            loading: false,
        })
    }

    parseBeatmapsetUrl = (url: string) => {
        if (url.includes('beatmapsets/'))
        {
            const fixedUrl = url.split('beatmapsets/');
            const beatmapsetId = fixedUrl[1].match(/\d+/);

            return beatmapsetId ? beatmapsetId[0] : ['error', 'something went wrong...'];
        }

        return ['error', 'something went wrong... make sure you use URL with \'/beatmapsets/\''];
    }

    render() {
        const { beatmapsetUrl, comment, loading, message } = this.state;

        return (
            <div>
                <div className="spotlights-nominate">
                    <div className="spotlights-nominate__nominate">
                        <form onSubmit={this.nominateBeatmap} className="spotlights-nominate__form">
                        <div className="spotlights-nominate__title">Nominate a beatmap</div>
                            <textarea
                                name="comment"
                                className="dark-form__textarea dark-form__textarea--resize"
                                rows={4}
                                maxLength={2000}
                                placeholder="put a comment here..."
                                onChange={this.handleInputChange}
                                value={comment}
                            />

                            <div className="spotlights-nominate__input">
                                <input
                                    name="beatmapsetUrl"
                                    className="dark-form__input dark-form__input--long"
                                    onChange={this.handleInputChange}
                                    autoComplete="off"
                                    value={beatmapsetUrl}
                                    placeholder="put a beatmap url here..."
                                />
                                <button type="submit" className={classModified('dark-form__button', ['inline', 'left', 'radius-square', 'small'])}>
                                    <i className="fa fa-check" /> Nominate!
                                </button>

                                <span className="spotlights-nominate__loading">
                                    {loading && <LoadingSpinner />}
                                </span>
                            </div>
                        </form>
                    </div>

                    {this.renderInfo()}
                </div>

                {message[0] && <Alert type={message[0]} message={message[1]} closeVar={this.closeMessage}/>}
            </div>
        );
    }

    renderInfo() {
        const { statistics } = this.props;

        return (
            <div className="spotlights-nominate__info">
                <div className="spotlights-nominate__info__grid">
                    {statistics.map((stat, index) => {
                        return (
                            <div className="spotlights-nominate__info__item" key={index}>
                                <div className="spotlights-nominate__info__el spotlights-nominate__info__el--key">
                                    {stat.name}
                                </div>
                                <div className="spotlights-nominate__info__el">
                                    {stat.value}
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        );
    }
}

export default NominateField;
