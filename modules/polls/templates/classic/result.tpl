<!--

**********************
* result.tpl         *
* (c) nabocorp, 2002 *
**********************

Here are the tags valid here:

{SURVEY_ID}: id of the current survey
{SURVEY_TITLE}: title of the current survey
{SURVEY_URL}: url of the current survey (as defined in the database)

{QUESTION_ID}: id of the current question
{QUESTION_TEXT}: text of the current question
{QUESTION_VOTES}: total number of votes for the current quesion

{ANSWER_ID}: id of the current answer
{ANSWER_TEXT}: text of the current answer
{ANSWER_VOTE}: number of votes for the current answer
{ANSWER_PCT}: percentage for the current answer
{ANSWER_BAR}: graphical bar representing the percentage for the current answer

-->

<p align="center">
<table width=450>
  <tr>
    <td colspan=2>
      <table cellspacing=0>
        <tr>
          <td bgcolor="gray" width=5></td>
          <td bgcolor="gray" valign="top"><font color="white" size="-1"><b>{QUESTION_ID}.</b></font></td>
          <td bgcolor="gray" width=5></td>
          <td bgcolor="gray" valign="top" width=450><font color="white" size="-1">{QUESTION_TEXT}</font></td>
        </tr>
      </table>
    </td>
  </tr>
  <!-- ANSWER START -->
  <tr>
    <td width="100%"><font size="-1">{ANSWER_TEXT}</font></td>
    <td valign="middle">{ANSWER_BAR}&nbsp;<i><font size="-3">{ANSWER_PCT}%&nbsp;({ANSWER_VOTE})</font></i></td>
  </tr>
  <!-- ANSWER END -->
  <tr>
    <td colspan=2><i><font size="-1">Votes: {QUESTION_VOTES}</font></i></td>
  </tr>
</table>
</p>