//
//  ReportViewController.h
//
//  Contributor(s): Ashley Lesperance, Jonas Yao, Robert Sanchez
//
//  Copyright (c) 2013 Number 13 Developer's Group
//


#import <UIKit/UIKit.h>
#import <MobileCoreServices/MobileCoreServices.h>
#import <CoreLocation/CoreLocation.h>
#import "ReportDataController.h"
#import "ConnectionDataController.h"

@interface ReportViewController : UIViewController <UITextFieldDelegate, UIImagePickerControllerDelegate, UINavigationControllerDelegate, UIPickerViewDelegate>
@property (weak, nonatomic) IBOutlet UIButton *Image;
//open the camera and take the picture
- (IBAction)ImageTaker:(id)sender;

@property (weak, nonatomic) IBOutlet UIImageView *imageView;
@property(strong, nonatomic) ReportViewController *reportController;

@property(nonatomic) BOOL hasReviewed;

//PickerView
@property (strong, nonatomic) IBOutlet UIPickerView *thePickerView;
//used to block other fields when using pickerview
@property (strong, nonatomic) IBOutlet UIView *pickerViewBlockerTop;
@property (strong, nonatomic) IBOutlet UIView *pickerViewBlockerBottom;

//-incident/severity array
@property (strong, nonatomic) NSArray *incidentSelection;
@property (strong, nonatomic) NSArray *severitySelection;
@property (strong, nonatomic) IBOutlet UILabel *incidentLabel;
@property (strong, nonatomic) IBOutlet UILabel *severityLabel;
//-Data from pickerview
@property (strong, nonatomic) NSString *incidentData;   //change to be consistent with server - same as severity
@property (strong, nonatomic) NSString *severityData;
@property (weak, nonatomic) IBOutlet UITextField *locationDisplay;

//temp variable for overview
@property (strong, nonatomic) NSString *incidentOverview;
@property (strong, nonatomic) NSString *severityOverview;
@property (strong, nonatomic) NSString *descriptionOverview;
@property (strong, nonatomic) UIImage *imageOverview;


@property (strong, nonatomic) IBOutlet UILabel *reviewWarning;
//now editButton
- (IBAction)incidentButtonPressed:(id)sender;
@property (strong, nonatomic) IBOutlet UIButton *editButton;
@property (strong, nonatomic) IBOutlet UILabel *editLabel;

@property(retain, nonatomic) ConnectionDataController *connectionManager;
@property(retain, nonatomic) ReportDataController *reportManager;

//now review/submit
- (IBAction)buttonToOverview:(id)sender;
@property (strong, nonatomic) IBOutlet UILabel *reviewSubmitLabel;


- (IBAction)reportEditPressed:(id)sender;
@property (strong, nonatomic) IBOutlet UILabel *reportEditLabel;


- (BOOL) verify: (NSString*) description;

@property (nonatomic) NSString *location;
@property (nonatomic) NSString *date;
@property(nonatomic) NSString *username;

@property (nonatomic) NSString *isPatrolling;

@property (weak, nonatomic) IBOutlet UITextField *description;
//put the image in the specific place and show it to the user
- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info;
@end
