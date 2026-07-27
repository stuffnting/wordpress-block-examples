/**
 * @wordpress dependencies
 */

import { __ } from "@wordpress/i18n";
import {
  Panel,
  PanelBody,
  PanelRow,
  NoticeList,
  TextareaControl,
  ToggleControl,
  FontSizePicker,
  Button,
  __experimentalHeading as Heading, // Experimental because WP backward compatibility guarantee doesn’t apply to them. They can change from one version to another, possibly breaking the code.
} from "@wordpress/components";
import { useState, useEffect } from "@wordpress/element";
import { useDispatch, useSelect } from "@wordpress/data";
import { store as noticesStore } from "@wordpress/notices";
import apiFetch from "@wordpress/api-fetch";

const MessageControl = ({ value, onChange }) => {
  return (
    <TextareaControl
      label={__("Message", "snt")}
      value={value}
      onChange={onChange}
      __nextHasNoMarginBottom //When new styles are introduced, they are put behind a feature flag prop prefixed by __next. This offers a grace period for third parties to make any necessary adjustments.
    />
  );
};

const DisplayControl = ({ value, onChange }) => {
  return <ToggleControl label={__("Display", "snt")} checked={value} onChange={onChange} __nextHasNoMarginBottom />;
};

const SizeControl = ({ value, onChange }) => {
  return (
    <FontSizePicker
      fontSizes={[
        {
          name: __("Small", "snt"),
          size: "small",
          slug: "small",
        },
        {
          name: __("Medium", "snt"),
          size: "medium",
          slug: "medium",
        },
        {
          name: __("Large", "snt"),
          size: "large",
          slug: "large",
        },
        {
          name: __("Extra Large", "snt"),
          size: "x-large",
          slug: "x-large",
        },
      ]}
      value={value}
      onChange={onChange}
      disableCustomFontSizes={true}
      __nextHasNoMarginBottom
    />
  );
};

const SaveButton = ({ onClick }) => {
  return (
    <Button variant="primary" onClick={onClick} __next40pxDefaultSize>
      {__("Save", "snt")}
    </Button>
  );
};

const SettingsTitle = () => {
  return <Heading level={1}>{__("SNT Setting Page", "snt")}</Heading>;
};

const Notices = () => {
  const { removeNotice } = useDispatch(noticesStore);
  const notices = useSelect((select) => select(noticesStore).getNotices());

  if (notices.length === 0) {
    return null;
  }

  return <NoticeList notices={notices} onRemove={removeNotice} />;
};

// A custom hook to handle the settings within the component
const useSettings = () => {
  const [message, setMessage] = useState("Hello, World!");
  const [display, setDisplay] = useState(true);
  const [size, setSize] = useState("medium");

  const { createSuccessNotice } = useDispatch(noticesStore);

  // Fetch the existing settings. useEffect triggers once component is mounted.
  useEffect(() => {
    apiFetch({ path: "/wp/v2/settings" }).then((settings) => {
      setMessage(settings.snt_settings_page.message);
      setDisplay(settings.snt_settings_page.display);
      setSize(settings.snt_settings_page.size);
    });
  }, []);

  // A function to save the new settings
  const saveSettings = () => {
    apiFetch({
      path: "/wp/v2/settings",
      method: "POST",
      data: {
        snt_settings_page: {
          message,
          display,
          size,
        },
      },
    }).then(() => {
      createSuccessNotice(__("Settings saved.", "snt"));
    });
  };

  return {
    message,
    setMessage,
    display,
    setDisplay,
    size,
    setSize,
    saveSettings,
  };
};

export const Settings = () => {
  const { message, setMessage, display, setDisplay, size, setSize, saveSettings } = useSettings();

  return (
    <>
      <SettingsTitle />
      <Notices />
      <Panel>
        <PanelBody>
          <PanelRow>
            <MessageControl value={message} onChange={(value) => setMessage(value)} />
          </PanelRow>
          <PanelRow>
            <DisplayControl value={display} onChange={(value) => setDisplay(value)} />
          </PanelRow>
        </PanelBody>
        <PanelBody title={__("Appearance", "snt")} initialOpen={false}>
          <PanelRow>
            <SizeControl value={size} onChange={(value) => setSize(value)} />
          </PanelRow>
        </PanelBody>
      </Panel>
      <SaveButton onClick={saveSettings} />
    </>
  );
};
