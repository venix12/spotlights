import React from 'react';
import Axios from 'axios';
import NominationComment from './nomination-comment';
import { LoadingSpinner } from '../loading-spinner';
import { Alert } from '../alert';

interface Props {
    nomination: Nomination,
    updateScore: (vote: Vote) => void,
    updateScoreOnChange: (votes: Vote[]) => void,
}

interface State {
    comment: string,
    loading: boolean,
    message: string[],
    vote: string,
    votes: Vote[],
}

class NominationDetails extends React.Component<Props, State> {
    state = {
        comment: '',
        loading: false,
        message: [],
        vote: '',
        votes: this.props.nomination.votes,
    }

    componentDidMount() {
        if (this.needsToUpdate()) {
            this.setState({
                comment: this.state.votes.find(x => x.voter.id === authUser.id)!.comment,
            })
        }

        $(function () {
            $('[title]').tooltip();
        });
    }

    closeMessage = () => {
        this.setState({
            message: [],
        });
    }

    getVoteCategoryByValue = (value?: number): string => {
        switch (value) {
            case -1:
                return 'criticizers';
            case 0:
                return 'neutrals';
            case 1:
                return 'supporters';
            case 2:
                return 'contributors';
            default:
                return '';
        }
    }

    getVotersListForRender = (usernames: string[]): string => {
        let list: string = '';

        usernames.forEach((username, index) => {
            list += `${index === 0 ? '' : ', '} ${username}`;
        });

        return list;
    }

    getVotersUsernames = (): { [key: string]: string[] } => {
        const { votes } = this.state;
        let voters: { [key: string]: string[] } = { contributors: [], criticizers: [], neutrals: [], supporters: [] };

        votes.forEach(vote => {
            if (vote.value !== null) {
                voters[this.getVoteCategoryByValue(vote.value)].push(vote.voter.username);
            }
        });

        return voters;
    }

    handleInputChange = (event: React.ChangeEvent<HTMLTextAreaElement>) => {
        const newState: any = { [event.target.name]: event.target.value }

        this.setState(newState);
    }

    render() {
        return (
            <div className="modal-body row">
                {this.renderVotePanel()}
                {this.renderComments()}
            </div>
        );
    }

    renderComments() {
        const { votes } = this.state;
        const comments = votes.filter(x => x.comment !== null);

        return (
            <div className="col-md-6"  style={{padding: '0 0 0 10px'}}>
                <div className="info-panel" style={{paddingRight: '0', height: '100%'}}>
                    <div className="spotlights-nominate__title">{`Comments (${comments.length})`}</div>
                    <div className="nomination-details__comments">
                        {comments.length > 0
                            ? comments.map(comment => {
                                return <NominationComment comment={comment} key={comment.id}/>;
                            })
                            : <span className="text-lightgray">there's no comments yet...</span>
                        }
                    </div>
                </div>
            </div>
        );
    }

    renderInfoSection() {
        const categories = ['supporters', 'neutrals', 'criticizers', 'contributors'];
        const voters = this.getVotersUsernames();

        return (
            <div className="nomination-details__stats">
                {categories.map((category, index) => {
                    return (
                        <div
                            className={`nomination-details__stats__el nomination-details__stats__el--${category}`}
                            title={this.getVotersListForRender(voters[category])}
                            key={index}
                        >
                            <div className="nomination-details__stats__el__content">
                                {
                                    `${voters[category].length} ${category}${voters[category].length > 0
                                        ? `: ${this.getVotersListForRender(voters[category])}`
                                        : ''
                                    }`
                                }
                            </div>
                        </div>
                    );
                })}
            </div>
        );
    }

    renderVotePanel() {
        const { comment, loading, message } = this.state;

        return (
            <div className="col-md-6" style={{padding: '0 10px 0 0'}}>
                <div className="info-panel">
                    <form onSubmit={this.storeVote}>
                        <div className="spotlights-nominate__title">Vote for a beatmap</div>
                        <textarea
                            name="comment"
                            className="dark-form__textarea"
                            placeholder="put a comment here..."
                            rows={10}
                            maxLength={2000}
                            onChange={this.handleInputChange}
                            value={comment}
                        />

                        <div className="nomination-details__voting">
                            <div className="info-badge">{`${comment.length} / 2000`}</div>

                            <div className="nomination-details__voting__options">
                                {this.isNotNominator() && this.renderVotingOptions()}

                                <div className="nomination-details__voting__el">
                                    {loading
                                        ? <LoadingSpinner />
                                        : <button className="dark-form__button dark-form__button--small">
                                            <i className="fa fa-check" /> {this.needsToUpdate() ? 'Update!' : this.isNotNominator() ? 'Vote!' : 'Comment!'}
                                        </button>
                                    }
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {message[0] && <Alert message={message[1]} type={message[0]} closeVar={this.closeMessage}/>}
                {this.renderInfoSection()}
            </div>
        );
    }

    renderVotingOptions() {
        const { vote } = this.state;

        const votingOptions = [
            { icon: 'thumbs-down', name: 'criticize', select: 'danger', title: 'Criticize the nomination' },
            { icon: 'question', name: 'neutral', select: 'blue', title: 'Vote for neutral' },
            { icon: 'thumbs-up', name: 'support', select: 'success', title: 'Support the nomination' },
            { icon: 'user', name: 'contribute', select: 'lightgray', title: 'I contributed to this map!' },
        ];

        const options = votingOptions.map((option, index) => {
            return (
                <div
                    className={`nomination-details__voting__el ${vote === option.name && `text-${option.select}`}`}
                    id={option.name}
                    onClick={() => this.selectVote(option.name)}
                    key={index}
                >
                    <i className={`fa fa-${option.icon}`} title={option.title} />
                </div>
            );
        })

        return options;
    }

    selectVote = (vote: string) => {
        this.setState({
            vote: this.state.vote === vote ? '' : vote
        });
    }

    storeVote = async (event: React.FormEvent<HTMLFormElement>) => {
        const { nomination } = this.props;
        const { comment, vote, votes } = this.state;

        event.preventDefault();

        this.setState({ loading: true });

        if (!vote && this.isNotNominator()) {
            this.setState({
                loading: false,
                message: ['error', 'you have to pick a vote!'],
            });

            return;
        }

        let postDestination = 'spotlights.store-vote';

        if (this.needsToUpdate()) {
            postDestination = 'spotlights.update-vote';
        }

        const res: { data: Vote } = await Axios.post(
            laroute.route(postDestination, { id: nomination.spots_id }),
            { comment: comment, id: nomination.id, vote: vote }
        );

        console.log(res.data);

        if (this.needsToUpdate()) {
            const newVotes = votes.slice();
            const newVote = newVotes.find(x => x.id === res.data.id);

            newVote!.comment = res.data.comment;
            newVote!.comment_updated_at = res.data.comment_updated_at;
            newVote!.value = res.data.value;

            this.props.updateScoreOnChange(newVotes);

            this.setState({
                comment: '',
                votes: newVotes,
                loading: false,
                message: ['success', 'successfully updated a vote!'],
                vote: '',
            });
        } else {
            this.props.updateScore(res.data);

            this.setState({
                comment: '',
                loading: false,
                message: ['success', 'successfully updated a vote!'],
                vote: '',
                votes: this.state.votes.concat(res.data),
            });
        }
    }

    /**
     * Checks
     */

    isNotNominator = (): boolean => {
        return this.props.nomination.nominator.id !== authUser.id;
    }

    needsToUpdate = (): boolean => {
        return this.state.votes.find(x => x.voter.id === authUser.id) != null;
    }
}

export default NominationDetails;
