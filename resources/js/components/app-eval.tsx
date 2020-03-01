import React from 'react';
import { render } from '../helpers/render';
import { parseJson } from '../helpers/helpers';
import AppCard from './app-card';

interface Props {
    applications: Application[],
}

interface State {
    applications: Application[],
    currentFilter?: string,
}

const modes = ['osu!', 'osu!taiko', 'osu!mania', 'osu!catch'];

class AppEval extends React.Component<Props, State> {
    state = {
        applications: this.props.applications,
        currentFilter: '',
    }

    filterByMode = (mode: string) => {
        const { applications } = this.props;
        const { currentFilter } = this.state;

        if (mode === currentFilter) {
            this.setState({
                applications: applications,
                currentFilter: ''
            });

            return;
        }

        const appsFiltered = applications.filter(x => x.gamemode === mode);

        this.setState({
            applications: appsFiltered,
            currentFilter: mode,
        });
    }

    render() {
        const { applications } = this.state;

        return (
            <div>
                {this.renderModeFilter()}

                <h5>Pending applications</h5>
                {this.renderAppCards(applications.filter(x => x.approved === false))}

                <h5>Finished applications</h5>
                {this.renderAppCards(applications.filter(x => x.approved === true))}
            </div>
        );
    }

    renderAppCards(apps: Application[]) {
        return (
            <div className="dark-section">
                <div className="app-cards">
                    {apps.map(app => {
                        return <AppCard application={app} key={app.id}/>
                    })}
                </div>
            </div>
        );
    }

    renderModeFilter() {
        const { currentFilter } = this.state;

        return (
            <div className="navigation">
                {modes.map((mode, index) => {
                    return <span
                        className={mode === currentFilter
                            ? 'navigation__el navigation__el--current'
                            : 'navigation__el'
                        }
                        key={index}
                        onClick={() => this.filterByMode(mode)}
                    >
                        {mode}
                    </span>
                })}
            </div>
        );
    }
}

render('app-eval', AppEval, {
    applications: parseJson('json-apps'),
})
