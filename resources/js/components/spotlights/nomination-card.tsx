import React from 'react';
import { classModified } from '../../helpers/helpers';
import NominationDetails from './nomination-details';

interface Props {
    is_legacy: boolean,
    nomination: Nomination,
    threshold?: number,
}

interface State {
    expanded: boolean,
    score: number,
}

class NominationCard extends React.Component<Props, State> {
    state = {
        expanded: false,
        score: this.props.nomination.score,
    }

    componentDidMount() {
        $(function () {
            $('[title]').tooltip();
        });
    }

    expand = () => {
        this.setState({
            expanded: this.state.expanded === true ? false : true,
        })
    }

    getNominationState = (): 'AWAITING VOTE' | 'NOMINATED' | 'PARTICIPATED' => {
        const { nomination } = this.props;

        if (nomination.nominator.id === authUser.id) {
            return 'NOMINATED';
        } else if (nomination.votes.find(x => x.voter.id === authUser.id)) {
            return 'PARTICIPATED';
        } else {
            return 'AWAITING VOTE';
        }
    }

    getScoreColor = (score: number): string => {
        switch (true) {
            case (score < -4):
                return '#ff0000';

            case (score < 0 && score > -5):
                return '#ff7373';

            case (score > 2 && score < 5):
                return '#6dbd6a';

            case (score > 4):
                return '#12b012';

            default:
                return '#d6d6d6';
        }
    }

    getStateColor = (state: 'AWAITING VOTE' | 'NOMINATED' | 'PARTICIPATED'): string => {
        switch (state) {
            case 'AWAITING VOTE':
                return 'red';
            case 'NOMINATED':
                return 'cyan';
            case 'PARTICIPATED':
                return 'greenyellow';
        }
    }

    render() {
        const { nomination } = this.props;
        const { expanded } = this.state;

        return(
            <>
                <div className="nomination-panel">
                    <div className="nomination-panel__background-container">
                        <div
                            style={{backgroundImage: `url(https://assets.ppy.sh/beatmaps/${nomination.beatmap_id}/covers/cover.jpg)`}}
                            className="nomination-panel__background"
                        />
                        <div className="nomination-panel__background-shadow"></div>
                    </div>

                    <div className="space-between" style={{width: '100%'}}>
                        <div className="d-flex">
                            {this.renderExpand()}
                            {this.renderScore()}
                            {this.renderMetadata()}
                        </div>

                        {this.renderInfo()}
                    </div>
                </div>

                {expanded && this.renderDetails()}
            </>
        )
    }

    renderDetails() {
        const { is_legacy, nomination } = this.props;

        return (
            <NominationDetails
                is_legacy={is_legacy}
                nomination={nomination}
                updateScore={this.updateScore}
                updateScoreOnChange={this.updateScoreOnChange}
            />
        );
    }

    renderExpand() {
        const { expanded } = this.state;

        return (
            <div className="nomination-panel__expand">
                <div
                    className={`nomination-panel__collapse nomination-panel__el nomination-panel__el--circle ${expanded ? 'open' : 'closed'}`}
                    onClick={() => this.expand()}
                >
                    <i className={`fa fa-chevron-right fa-margin`} />
                </div>
            </div>
        );
    }

    renderInfo() {
        const { nomination } = this.props;
        const state = this.getNominationState();

        return (
            <div className="d-flex align-items-center">
                <div className="nomination-panel__state-container">
                    <div
                        className={`nomination-panel__el nomination-panel__el--5 ${classModified('nomination-panel__info', ['inverted'])}`}
                    >
                        <span style={{color: this.getStateColor(state)}}>{state}</span>
                    </div>
                </div>

                <div className="nomination-panel__el nomination-panel__el--5 nomination-panel__vote-info">
                    <div style={{lineHeight: '15px'}}>
                        <i className="fa fa-user fa-fw" title="participants" /> {nomination.votes.length} <br />
                        <i className="fa fa-thumbs-up fa-fw" title="supporters" /> {nomination.votes.filter(x => x.value === 1).length} <br />
                        <i className="fa fa-thumbs-down fa-fw" title="criticizers" /> {nomination.votes.filter(x => x.value === -1).length}
                    </div>
                </div>
            </div>
        );
    }

    renderMetadata() {
        const { nomination } = this.props;

        return (
            <div>
                <span className="nomination-panel__el nomination-panel__el--5 nomination-panel__info nomination-panel__info--metadata">
                    <a href={`https://osu.ppy.sh/beatmapsets/${nomination.beatmap_id}`} className="text-dark-2">
                        {`${nomination.artist} - ${nomination.title}`}
                    </a>
                </span>

                <span className="nomination-panel__el nomination-panel__el--5 nomination-panel__info">
                    created by <a href={`https://osu.ppy.sh/users/${nomination.creator_osu_id}`} className="text-dark-2">
                        {nomination.creator}
                    </a>
                </span>

                <span className={`nomination-panel__el nomination-panel__el--5 ${classModified('nomination-panel__info', ['inverted', 'left'])}`}>
                    nominated by <a href={laroute.route('user.profile', { id: nomination.nominator.id })}>
                        {nomination.nominator.username}
                    </a>
                </span>
            </div>
        );
    }

    renderScore() {
        const { is_legacy, threshold } = this.props;
        const { score } = this.state;

        const spotlighted = (threshold && score >= threshold) && 'nomination-panel__score--spotlighted'

        return (
            <div
                className={`nomination-panel__el nomination-panel__el--10 nomination-panel__score ${spotlighted}`}
                style={{color: this.getScoreColor(score)}}
            >
                {score}
            </div>
        );
    }

    updateScore = (vote: Vote) => {
        this.setState({
            score: this.state.score += vote.value,
        });
    }

    updateScoreOnChange = (votes: Vote[]) => {
        let score = this.props.is_legacy ? 1 : 0;

        votes.forEach(vote => {
            score += vote.value;
        });

        if (!this.props.is_legacy) {
            score = score / votes.length;
        }

        this.setState({
            score: score,
        });
    }
}

export default NominationCard;
