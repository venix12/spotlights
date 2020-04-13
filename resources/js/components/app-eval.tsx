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
                <div id="modal" />

                <div className="dark-section-select">
                    {this.renderModeFilter()}
                </div>

                <div className="dark-section dark-section--4">
                    {this.renderAppCards(applications.filter(x => x.approved === false), 'Pending Applications')}

                    {this.renderAppCards(applications.filter(x => x.approved === true), 'Finished Applications')}
                </div>
            </div>
        );
    }

    renderAppCards(apps: Application[], title: string) {
        return (
            <div className="info-panel">
                <div className="info-panel__header">{title} ({apps.length})</div>
                <div className="app-cards">
                    {apps.map(app => {
                        return <AppCard application={app} key={app.id} />
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
