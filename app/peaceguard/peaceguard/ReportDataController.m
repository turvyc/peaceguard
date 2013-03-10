//
//  ReportDataController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import "ReportDataController.h"
#import "Report.h"

@interface ReportDataController ()
- (void)initializeDefaultDataList;
@end

@implementation ReportDataController

- (void)initializeDefaultDataList {
    NSMutableArray *report_list = [[NSMutableArray alloc] init];
    self.masterReport = report_list;
    Report *report;
    report = [[Report alloc] initWithName:@"First Incident" description:@"Test only"];
    [self addReport:report];
}

- (void)setMasterReport:(NSMutableArray *)newList {
    if(_masterReport != newList) {
        _masterReport = [newList mutableCopy];
    }
}

- (id)init {
    if(self = [super init]) {
        [self initializeDefaultDataList];
        
        return self;
    }
    
    return nil;
    
}

- (NSUInteger)countOfMasterReport {
    return [self.masterReport count];
}

- (Report *)objectInMasterReportAtIndex:(NSUInteger)index {
    return [self.masterReport objectAtIndex:index];
}

- (void)addReport:(Report *)report {
    [self.masterReport addObject:report];
}
@end
