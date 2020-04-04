import React from 'react';
import { render } from '../../helpers/render';
import NominateField from './nominate-field';
import { parseJson } from '../../helpers/helpers';
import NominationCard from './nomination-card';

interface Props {
    spotlights: Spotlights,
    statistics: SpotlightsStatistic[],
}

interface State {
    nominations: Nomination[],
}

class Main extends React.Component<Props, State> {
    state = {
        nominations: this.props.spotlights.nominations.sort((x, y) => y.score - x.score),
    }

    render() {
        const { spotlights, statistics } = this.props;
        const { nominations } = this.state;

        return (
            <div>
                <div className="dark-section dark-section--3">
                    <NominateField
                        nominateBeatmap={this.nominateBeatmap}
                        spotlights={spotlights}
                        statistics={statistics}
                    />
                </div>

                <div className="dark-section dark-section--4">
                    <div className="navigation-panels">
                        {nominations.map(nomination => {
                            return <NominationCard nomination={nomination} threshold={spotlights.threshold} key={nomination.id} />
                        })}
                    </div>
                </div>
            </div>
        );
    }

    nominateBeatmap = (data: Nomination) => {
        const { nominations } = this.state;

        const joined = nominations.concat(data);

        this.setState({
            nominations: joined,
        })
    }
}

render('spotlights-main', Main, {
    spotlights: parseJson('json-spotlights'),
    statistics: parseJson('json-statistics'),
});

export default Main;
